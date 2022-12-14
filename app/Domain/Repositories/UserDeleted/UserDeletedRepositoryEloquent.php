<?php

namespace App\Domain\Repositories\UserDeleted;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\UserDeleted;

class UserDeletedRepositoryEloquent implements UserDeletedRepositoryInterface
{
    use RepositoryEloquent;
    protected UserDeleted $model;
    public function __construct(UserDeleted $userDeleted)
    {
        $this->model    =   $userDeleted;
    }
}
