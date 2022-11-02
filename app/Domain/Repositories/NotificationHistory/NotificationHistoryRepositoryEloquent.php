<?php

namespace App\Domain\Repositories\NotificationHistory;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\NotificationHistory;

class NotificationHistoryRepositoryEloquent implements NotificationHistoryRepositoryInterface
{
    use RepositoryEloquent;
    protected NotificationHistory $model;
    public function __construct(NotificationHistory $notificationHistory)
    {
        $this->model    =   $notificationHistory;
    }
}
