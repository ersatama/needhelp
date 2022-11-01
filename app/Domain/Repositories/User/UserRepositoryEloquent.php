<?php

namespace App\Domain\Repositories\User;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\User;

class UserRepositoryEloquent implements UserRepositoryInterface
{
    use RepositoryEloquent;
    protected User $model;
    public function __construct(User $user)
    {
        $this->model    =   $user;
    }
}
