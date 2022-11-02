<?php

namespace App\Domain\Repositories\Notification;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Notification;

class NotificationRepositoryEloquent implements NotificationRepositoryInterface
{
    use RepositoryEloquent;
    protected Notification $model;
    public function __construct(Notification $notification)
    {
        $this->model    =   $notification;
    }
}
