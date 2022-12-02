<?php

namespace App\Domain\Repositories\Notification;

use App\Domain\Contracts\Contract;
use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

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

    public static function priceLastWeek()
    {
        return Notification::select(DB::raw('sum(price) as sum'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where([
                [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                [Contract::IS_PAID, true],
                [Contract::STATUS,'!=',0]
            ])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }
}
