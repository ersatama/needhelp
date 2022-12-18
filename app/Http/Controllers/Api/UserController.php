<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\ErrorContract;
use App\Domain\Contracts\UserContract;
use App\Domain\Helpers\Smsc;
use App\Domain\Requests\User\CreateRequest;
use App\Domain\Requests\User\SearchRequest;
use App\Domain\Requests\User\UpdateRequest;
use App\Domain\Services\PhoneCodeService;
use App\Domain\Services\UserDeletedService;
use App\Domain\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected UserService $userService;
    protected PhoneCodeService $phoneCodeService;
    protected UserDeletedService $userDeletedService;

    public function __construct(UserService $userService, PhoneCodeService $phoneCodeService, UserDeletedService $userDeletedService)
    {
        $this->userService  =   $userService;
        $this->phoneCodeService =   $phoneCodeService;
        $this->userDeletedService   =   $userDeletedService;
    }

    /**
     * @hideFromAPIDocumentation
     * userDateBetween - User
     *
     * @group User
     */
    public function userDateBetween($start,$end)
    {
        return $this->userService->userRepository::userDateBetween($start,$end);
    }

    /**
     * @hideFromAPIDocumentation
     * deleteById - User
     *
     * @group User
     */
    public function deleteById($id): Response|Application|ResponseFactory
    {
        if ($user = $this->userService->userRepository->firstById($id)) {
            if ($userDeleted = $this->userDeletedService->userDeletedRepository->firstByPhone($user->{Contract::PHONE})) {
                $this->userDeletedService->userDeletedRepository->forceDeleteById($userDeleted->{Contract::ID});
            }
            $this->userDeletedService->userDeletedRepository->insert($user->toArray());
            $this->userService->userRepository->forceDeleteById($user->{Contract::ID});
            return response(ErrorContract::DELETED, 200);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * deleteByPhone - User
     *
     * @group User
     */
    public function deleteByPhone($phone): Response|Application|ResponseFactory
    {
        if ($user = $this->userService->userRepository->firstByPhone($phone)) {
            if ($userDeleted = $this->userDeletedService->userDeletedRepository->firstByPhone($user->{Contract::PHONE})) {
                $this->userDeletedService->userDeletedRepository->forceDeleteById($userDeleted->{Contract::ID});
            }
            $this->userDeletedService->userDeletedRepository->insert($user->toArray());
            $this->userService->userRepository->forceDeleteById($user->{Contract::ID});
            return response(ErrorContract::DELETED, 200);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * @hideFromAPIDocumentation
     * restoreById - User
     *
     * @group User
     */
    public function restoreById($id): Response|Application|ResponseFactory
    {
        if ($user = $this->userService->userRepository->firstById($id)) {
            return response(ErrorContract::RESTORED, 200);
        }
        if ($userDeleted = $this->userDeletedService->userDeletedRepository->firstById($id)) {
            $this->userService->userRepository->insert($userDeleted->toArray());
            $this->userDeletedService->userDeletedRepository->forceDeleteById($userDeleted->{Contract::ID});
            return response(ErrorContract::RESTORED, 200);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * restoreByPhone - User
     *
     * @group User
     */
    public function restoreByPhone($phone): Response|Application|ResponseFactory
    {
        if ($user = $this->userService->userRepository->firstByPhone($phone)) {
            return response(ErrorContract::RESTORED, 200);
        }
        if ($userDeleted = $this->userDeletedService->userDeletedRepository->firstByPhone($phone)) {
            $this->userService->userRepository->insert($userDeleted->toArray());
            $this->userDeletedService->userDeletedRepository->forceDeleteById($userDeleted->{Contract::ID});
            return response(ErrorContract::RESTORED, 200);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * firstByPhone - User
     *
     * @group User
     */
    public function firstByPhone($phone): Response|Application|ResponseFactory|UserResource
    {
        if ($user = $this->userService->userRepository->firstByPhone($phone)) {
            return new UserResource($user);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * sendRegisterCode - User
     *
     * @group User
     */
    public function sendRegisterCode($phone): Response|Application|ResponseFactory
    {
        return $this->resendRegisterCode($phone);
    }

    /**
     * resendRegisterCode - User
     *
     * @group User
     */
    public function resendRegisterCode($phone): Response|Application|ResponseFactory
    {
        $data   =   [
            Contract::PHONE =>  $phone,
            Contract::CODE  =>  rand(1000,9999),
            Contract::STATUS    =>  ErrorContract::NOT_REGISTERED,
        ];
        if ($phoneCode = $this->phoneCodeService->phoneCodeRepository->firstByPhone($phone)) {
            $this->phoneCodeService->phoneCodeRepository->update($phoneCode->{Contract::ID}, [
                Contract::CODE  =>  $data[Contract::CODE]
            ]);
        } else {
            $this->phoneCodeService->phoneCodeRepository->create([
                Contract::PHONE =>  $phone,
                Contract::CODE  =>  $data[Contract::CODE],
            ]);
        }
        Smsc::sendCode($phone, $data[Contract::CODE]);
        return response($data, 200);
    }

    /**
     * resetPassword - User
     *
     * @group User
     */
    public function resetPassword($phone): Response|Application|ResponseFactory
    {
        $data   =   [
            Contract::PHONE =>  $phone,
            Contract::CODE  =>  rand(1000,9999),
            Contract::STATUS    =>  ErrorContract::CODE_SENT,
        ];
        if ($phoneCode  =   $this->phoneCodeService->phoneCodeRepository->firstByPhone($phone)) {
            $this->phoneCodeService->phoneCodeRepository->update($phoneCode->{Contract::ID}, [
                Contract::CODE  =>  $data[Contract::CODE]
            ]);
            $this->userService->userRepository->updateByPhone($phone,[
                Contract::PASSWORD  =>  $data[Contract::CODE]
            ]);
        } else {
            $this->phoneCodeService->phoneCodeRepository->create([
                Contract::PHONE =>  $phone,
                Contract::CODE  =>  $data[Contract::CODE]
            ]);
        }
        Smsc::sendCode($phone, $data[Contract::CODE]);
        return response($data, 200);
    }

    /**
     * checkCode - User
     *
     * @group User
     */
    public function checkCode($phone, $code): Response|Application|ResponseFactory
    {
        if ($phoneCode  =   $this->phoneCodeService->phoneCodeRepository->firstByPhone($phone)) {
            if ($phoneCode->{Contract::CODE} === $code) {
                return response([
                    Contract::MESSAGE   =>  Contract::SUCCESS
                ], 200);
            }
        }
        return response(ErrorContract::INCORRECT_CODE, 400);
    }

    /**
     * checkUserByPhone - User
     *
     * @group User
     */
    public function checkUserByPhone($phone): Response|Application|ResponseFactory
    {
        if ($user = $this->userService->userRepository->firstByPhone($phone)) {
            return response(Contract::SUCCESS, 200);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * @hideFromAPIDocumentation
     * firstById - User
     *
     * @group User
     */
    public function firstById($id): Response|Application|ResponseFactory|UserResource
    {
        if ($user = $this->userService->userRepository->firstById($id)) {
            return new UserResource($user);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * create - User
     *
     * @group User
     * @throws ValidationException
     */
    public function create(CreateRequest $createRequest): Response|Application|ResponseFactory|UserResource
    {
        $data   =   $createRequest->checked();
        if ($phoneCode = $this->phoneCodeService->getCodeByPhone($data[Contract::PHONE])) {
            $data[Contract::PASSWORD]   =   $phoneCode->{Contract::CODE};
            return new UserResource($this->userService->userRepository->create($data));
        }
        return response(ErrorContract::SMS_NOT_SENT, 400);
    }

    /**
     * auth Phone & Password - User
     *
     * @group User
     */
    public function auth($phone, $password): Response|Application|ResponseFactory|UserResource
    {
        if ($user = $this->userService->userRepository->firstByPhone($phone)) {
            if (Hash::check($password, $user->{Contract::PASSWORD})) {
                return new UserResource($user);
            }
            return response(ErrorContract::INCORRECT_PASSWORD, 404);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * update - User
     *
     * @group User
     * @throws ValidationException
     */
    public function update($id, UpdateRequest $updateRequest): Response|Application|ResponseFactory|UserResource
    {
        if ($user = $this->userService->userRepository->update($id, $updateRequest->checked())) {
            return new UserResource($user);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * @hideFromAPIDocumentation
     *
     * @throws ValidationException
     */
    public function search(SearchRequest $searchRequest): UserCollection|array
    {
        if ($search = $searchRequest->checked()) {
            $search =   $this->userService->userRepository->search(UserContract::SEARCH,$search);
            if (sizeof($search) > 0) {
                return new UserCollection($search);
            }
            return [];
        }
        $users  =   $this->userService->userRepository->all();
        if (sizeof($users) === 0) {
            return [];
        }
        return new UserCollection($users);
    }
}
