<?php

namespace App\Domain\Repositories\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuestionRepositoryEloquent implements QuestionRepositoryInterface
{
    use RepositoryEloquent;
    protected Question $model;
    public function __construct(Question $notification)
    {
        $this->model    =   $notification;
    }

    public static function count($arr = [])
    {
        return Question::where($arr)->count();
    }

    public static function countLastMonth($arr = [])
    {
        return Question::where($arr)->where(Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay())->count();
    }

    public static function sum($column, $condition)
    {
        return Question::where($condition)->sum($column);
    }

    public static function sumLastMonth($column, $condition)
    {
        return Question::where($condition)
            ->where(Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay())
            ->sum($column);
    }

    public static function _getByUserId($userId)
    {
        return Question::where(Contract::USER_ID, $userId)->get();
    }

    public static function _getByLawyerId($lawyerId)
    {
        return Question::where(Contract::LAWYER_ID, $lawyerId)->get();
    }

    public static function priceLastWeek()
    {
        return Question::select(DB::raw('sum(price) as sum'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where([
                [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                [Contract::IS_PAID, true],
                [Contract::STATUS,'!=',0]
            ])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }
}
