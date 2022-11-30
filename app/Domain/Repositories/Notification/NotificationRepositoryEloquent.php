<?php

namespace App\Domain\Repositories\Notification;

use App\Domain\Contracts\Contract;
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

    public static function count($arr = [])
    {
        return Notification::where($arr)->count();
    }

    public static function countLastMonth($arr = [])
    {
        return Notification::where($arr)->where(Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay())->count();
    }

    public static function sum($column, $condition)
    {
        return Notification::where($condition)->sum($column);
    }

    public static function sumLastMonth($column, $condition)
    {
        return Notification::where($condition)
            ->where(Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay())
            ->sum($column);
    }

    public static function _getByUserId($userId)
    {
        return Notification::where(Contract::USER_ID, $userId)->get();
    }

    public static function _getByLawyerId($lawyerId)
    {
        return Notification::where(Contract::LAWYER_ID, $lawyerId)->get();
    }
}
