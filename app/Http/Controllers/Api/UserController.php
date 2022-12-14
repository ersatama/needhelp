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
    public function __construct(UserService $userService, PhoneCodeService $phoneCodeService)
    {
        $this->userService  =   $userService;
        $this->phoneCodeService =   $phoneCodeService;
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
        return response($data, 401);
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
        return response($data, 401);
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
                return response(Contract::SUCCESS, 200);
            }
        }
        return response(ErrorContract::INCORRECT_CODE, 400);
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
    public function create(CreateRequest $createRequest): UserResource
    {
        $data   =   $createRequest->checked();
        $data[Contract::PASSWORD]   =   $this->phoneCodeService->getCodeByPhone($data[Contract::PHONE]);
        return new UserResource($this->userService->userRepository->create($data));
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
