<?php

namespace App\Domain\Services;

use App\Domain\Repositories\NotificationHistory\NotificationHistoryRepositoryInterface;

class NotificationHistoryService extends Service
{
    public NotificationHistoryRepositoryInterface $notificationHistoryRepository;
    public function __construct(NotificationHistoryRepositoryInterface $notificationHistoryRepository)
    {
        $this->notificationHistoryRepository    =   $notificationHistoryRepository;
    }
}
