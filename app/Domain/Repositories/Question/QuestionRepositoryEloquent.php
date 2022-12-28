<?php

namespace App\Domain\Repositories\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Repositories\RepositoryEloquent;
use App\Domain\Scopes\Page;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class QuestionRepositoryEloquent implements QuestionRepositoryInterface
{
    use RepositoryEloquent;
    protected Question $model;
    public function __construct(Question $question)
    {
        $this->model    =   $question;
    }

    public static function lawyerCountToday($where)
    {
        return Question::where($where)->withoutGlobalScope(Page::class)->count();
    }

    public function getWhere($where): Collection|array
    {
        $data   =   [];
        foreach ($where as $key=>$value) {
            if ($key !== Contract::SEARCH) {
                $data[] =   [$key, $value];
            }
        }
        $query  =   $this->model::with('user','lawyer');
        if (array_key_exists(Contract::SEARCH, $where)) {
            $query->where(array_merge($data, [
                [Contract::ID, 'like', $where[Contract::SEARCH] . '%']
            ]));
            $query->orWhere(array_merge($data, [
                [Contract::ANSWER, 'like', $where[Contract::SEARCH] . '%']
            ]));
            $query->orWhere(array_merge($data, [
                [Contract::TITLE, 'like', $where[Contract::SEARCH] . '%']
            ]));
        } else {
            $query->where($data);
        }
        return $query->withoutGlobalScope(Page::class)->get();
    }

    public function countQuestion($where)
    {
        $data   =   [];
        foreach ($where as $key=>$value) {
            if ($key !== Contract::SEARCH) {
                $data[] =   [$key, $value];
            }
        }
        $query  =   $this->model::with('user','lawyer');
        if (array_key_exists(Contract::SEARCH, $where)) {
            $query->where(array_merge($data, [
                [Contract::ID, 'like', $where[Contract::SEARCH] . '%']
            ]));
            $query->orWhere(array_merge($data, [
                [Contract::ANSWER, 'like', $where[Contract::SEARCH] . '%']
            ]));
            $query->orWhere(array_merge($data, [
                [Contract::TITLE, 'like', $where[Contract::SEARCH] . '%']
            ]));
        } else {
            $query->where($data);
        }
        return $query->withoutGlobalScope(Page::class)->count();
    }

    public static function count($arr = [])
    {
        return Question::where($arr)->withoutGlobalScope(Page::class)->count();
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

    public static function countDateBetweenClosedWhere($start, $end, $where)
    {
        return Question::select(DB::raw('count(id) as count'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where($where)
            ->whereBetween(Contract::CREATED_AT, [$start.' 00:00:00',$end.' 23:59:59'])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }

    public static function countDateBetweenClosed($start, $end)
    {
        return Question::select(DB::raw('count(id) as count'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where([
                [Contract::IS_PAID,true],
                [Contract::STATUS,2]
            ])
            ->whereBetween(Contract::CREATED_AT, [$start.' 00:00:00',$end.' 23:59:59'])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }

    public static function countDateBetween($start, $end)
    {
        return Question::select(DB::raw('count(id) as count'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where([
                [Contract::IS_PAID,true],
                [Contract::STATUS,1]
            ])
            ->whereBetween(Contract::CREATED_AT, [$start.' 00:00:00',$end.' 23:59:59'])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }

    public static function countWhereYear($where = [])
    {
        return Question::select(DB::raw('count(id) as count'),DB::raw("DATE_FORMAT(created_at, '%Y-%m') as date"))
            ->where($where)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))->get();
    }

    public static function openClosedPercentage($where)
    {
        return Question::select(DB::raw('count(id) as count'),DB::raw(Contract::IS_IMPORTANT))
            ->where($where)
            ->groupBy(Contract::IS_IMPORTANT)
            ->get();
    }

    public static function countWhere($where = [])
    {
        return Question::select(DB::raw('count(id) as count'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where($where)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }

    public static function priceLastWeek()
    {
        return Question::select(DB::raw('sum(price) as sum'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where([
                [Contract::CREATED_AT, '>', now()->subDays(7)->endOfDay()],
                [Contract::IS_PAID, true],
            ])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }

    public static function priceLastMonth()
    {
        return Question::select(DB::raw('sum(price) as sum'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where([
                [Contract::CREATED_AT, '>', now()->subDays(30)->endOfDay()],
                [Contract::IS_PAID, true],
            ])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }

    public static function priceLastYear()
    {
        return Question::select(DB::raw('sum(price) as sum'),DB::raw("DATE_FORMAT(created_at, '%Y-%m') as date"))
            ->where([
                [Contract::CREATED_AT, '>', now()->subDays(365)->endOfDay()],
                [Contract::IS_PAID, true],
            ])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))->get();
    }

    public static function priceDateBetween($start, $end)
    {
        return Question::select(DB::raw('sum(price) as sum'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where(Contract::IS_PAID, true)
            ->whereBetween(Contract::CREATED_AT, [$start.' 00:00:00',$end.' 23:59:59'])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }
}
