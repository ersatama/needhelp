<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\NotificationGlobalService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationGlobalController extends Controller
{
    protected NotificationGlobalService $notificationGlobalService;
    public function __construct(NotificationGlobalService $notificationGlobalService)
    {
        $this->notificationGlobalService    =   $notificationGlobalService;
    }
}
