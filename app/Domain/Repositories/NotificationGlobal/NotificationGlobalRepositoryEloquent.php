<?php

namespace App\Domain\Repositories\NotificationGlobal;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\NotificationGlobal;

class NotificationGlobalRepositoryEloquent implements NotificationGlobalRepositoryInterface
{
    use RepositoryEloquent;
    protected NotificationGlobal $model;
    public function __construct(NotificationGlobal $notificationGlobal)
    {
        $this->model    =   $notificationGlobal;
    }
}
