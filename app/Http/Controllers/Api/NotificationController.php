<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\NotificationService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationCollection;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService  =   $notificationService;
    }

    /**
     * getByUserId - Notification
     *
     * @group Notification
     */
    public function getByUserId($userId): NotificationCollection
    {
        return new NotificationCollection($this->notificationService->notificationRepository->getByUserId($userId));
    }
}
