<?php

namespace App\Domain\Services;

use App\Domain\Repositories\NotificationGlobal\NotificationGlobalRepositoryInterface;

class NotificationGlobalService extends Service
{
    public NotificationGlobalRepositoryInterface $notificationGlobalRepository;
    public function __construct(NotificationGlobalRepositoryInterface $notificationGlobalRepository)
    {
        $this->notificationGlobalRepository =   $notificationGlobalRepository;
    }
}
