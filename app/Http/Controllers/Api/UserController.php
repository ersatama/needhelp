<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\ErrorContract;
use App\Domain\Contracts\UserContract;
use App\Domain\Requests\User\SearchRequest;
use App\Domain\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        return response(ErrorContract::NOT_FOUND, 401);
    }

    /**
     * @hideFromAPIDocumentation
     *
     * @throws ValidationException
     */
    public function search(SearchRequest $searchRequest)
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
