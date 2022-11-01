<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\ErrorContract;
use App\Domain\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService  =   $userService;
    }

    public function firstById($id): Response|Application|ResponseFactory|UserResource
    {
        if ($user = $this->userService->userRepository->firstById($id)) {
            return new UserResource($user);
        }
        return response(ErrorContract::NOT_FOUND, 401);
    }
}
