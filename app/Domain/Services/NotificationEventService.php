<?php

namespace App\Domain\Services;

use App\Domain\Repositories\NotificationEvent\NotificationEventRepositoryInterface;

class NotificationEventService extends Service
{
    public NotificationEventRepositoryInterface $notificationEventRepository;
    public function __construct(NotificationEventRepositoryInterface $notificationEventRepository)
    {
        $this->notificationEventRepository  =   $notificationEventRepository;
    }
}
