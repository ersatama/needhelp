<?php

namespace App\Domain\Repositories\User;

use App\Domain\Contracts\Contract;
use App\Domain\Repositories\RepositoryEloquent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public static function _getById($id)
    {
        return User::where(Contract::ID,$id)->first();
    }

    public static function userLastWeek()
    {
        return User::select(DB::raw('count(id) as count'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where(Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay())
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }
}
