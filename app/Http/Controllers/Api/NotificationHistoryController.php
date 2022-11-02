<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\NotificationHistoryService;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationHistory\NotificationHistoryCollection;
use Illuminate\Http\Request;

class NotificationHistoryController extends Controller
{
    protected NotificationHistoryService $notificationHistoryService;
    public function __construct(NotificationHistoryService $notificationHistoryService)
    {
        $this->notificationHistoryService   =   $notificationHistoryService;
    }

    /**
     * getByNotificationId - NotificationHistory
     *
     * @group NotificationHistory
     */
    public function getByNotificationId($notificationId): NotificationHistoryCollection
    {
        return new NotificationHistoryCollection($this->notificationHistoryService->notificationHistoryRepository->getByNotificationId($notificationId));
    }
}
