<?php

namespace App\Domain\Repositories\NotificationEvent;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\NotificationEvent;

class NotificationEventRepositoryEloquent implements NotificationEventRepositoryInterface
{
    use RepositoryEloquent;
    protected NotificationEvent $model;
    public function __construct(NotificationEvent $notificationEvent)
    {
        $this->model    =   $notificationEvent;
    }
}
