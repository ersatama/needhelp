<?php

namespace App\Domain\Repositories\User;

use App\Domain\Contracts\Contract;
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

    public static function count($arr = [])
    {
        return User::where($arr)->count();
    }

    public static function countLastMonth($arr = [])
    {
        return User::where($arr)->where(Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay())->count();
    }
}
