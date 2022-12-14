<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\UserDeletedService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDeletedController extends Controller
{
    protected UserDeletedService $userDeletedService;
    public function __construct(UserDeletedService $userDeletedService)
    {
        $this->userDeletedService   =   $userDeletedService;
    }
}
