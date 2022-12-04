<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\ErrorContract;
use App\Domain\Contracts\UserContract;
use App\Domain\Requests\User\CreateRequest;
use App\Domain\Requests\User\SearchRequest;
use App\Domain\Requests\User\UpdateRequest;
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
    public function __construct(UserService $userService)
    {
        $this->userService  =   $userService;
    }

    /**
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
        return new UserResource($this->userService->userRepository->create($createRequest->checked()));
    }

    /**
     * codeVerify ID & Code - User
     *
     * @group User
     */
    public function codeVerify($id, $code): Response|Application|ResponseFactory|UserResource
    {
        if ($user = $this->userService->userRepository->firstById($id)) {
            if ((int)$user->{Contract::PHONE_CODE} === (int)$code) {
                $user->{Contract::PHONE_VERIFIED_AT}    =   Carbon::now();
                $user->save();
                return new UserResource($user);
            }
            return response(ErrorContract::INCORRECT_CODE, 400);
        }
        return response(ErrorContract::NOT_FOUND, 404);
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
