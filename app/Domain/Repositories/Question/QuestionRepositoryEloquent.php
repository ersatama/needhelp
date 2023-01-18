<?php

namespace App\Domain\Repositories\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Repositories\RepositoryEloquent;
use App\Domain\Scopes\IsPaid;
use App\Domain\Scopes\Page;
use App\Models\Question;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Builder;
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

    public static function lawyerCountToday($lawyerId)
    {
        return Question::where(Contract::LAWYER_ID, $lawyerId)->where(Contract::UPDATED_AT,'like',date('Y-m-d').'%')
            ->withoutGlobalScope(Page::class)->count();
    }

    /**
     * @param $questions
     * @return array
     * @throws Exception
     */
    public static function getQuestion($questions): array
    {
        $arr = [];
        foreach ($questions as &$question) {
            $parsedDate = Carbon::createFromFormat('Y-m-d H:i:s', $question->{Contract::CREATED_AT})->format('Y-m-d H:i:s');
            $splitDate = explode(' ', $parsedDate);
            $date = new DateTime($question->{Contract::CREATED_AT});
            $answeredDate = new DateTime($question->{Contract::ANSWERED_AT});
            $interval = $date->diff($answeredDate);
            $interval = $interval->s;
            if (!array_key_exists($splitDate[0], $arr)) {
                $arr[$splitDate[0]] = [
                    Contract::DATE => $splitDate[0],
                    Contract::COUNT => 1,
                    Contract::AVERAGE => $interval,
                ];
            } else {
                $arr[$splitDate[0]][Contract::COUNT] = $arr[$splitDate[0]][Contract::COUNT] + 1;
                $arr[$splitDate[0]][Contract::AVERAGE] = $arr[$splitDate[0]][Contract::AVERAGE] + $interval;
            }
        }

        foreach ($arr as $key => $value) {
            $time = round($value[Contract::AVERAGE] / $value[Contract::COUNT]);
            $arr[$key][Contract::AVERAGE] = sprintf('%02d:%02d:%02d', ($time / 3600), ($time / 60 % 60), $time % 60);
        }
        return $arr;
    }

    public function getWhere($where): Collection|array
    {
        $query = $this->getBuilder($where);


        return $query->get();
    }

    public function countQuestion($where): int
    {
        $query = $this->getBuilder($where);
        return $query->withoutGlobalScope(Page::class)->count();
    }

    public static function count($where = [])
    {
        return Question::where($where)->withoutGlobalScope(Page::class)->count();
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

    public static function averageTimeBetweenClosedWhere($start, $end, $where)
    {
        $questions  =   Question::select(DB::raw(Contract::CREATED_AT),DB::raw(Contract::ANSWERED_AT))
            ->where($where)
            ->whereBetween(Contract::CREATED_AT, [$start.' 00:00:00',$end.' 23:59:59'])
            ->get();
        return self::getQuestion($questions);
    }

    public static function countDateBetweenClosedWhere($start, $end, $where)
    {
        return Question::select(DB::raw('count(id) as count'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where($where)
            ->whereBetween(Contract::CREATED_AT, [$start.' 00:00:00',$end.' 23:59:59'])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))->get();
    }

    public static function averageBetweenClosed($start, $end)
    {
        $questions  =   Question::select(DB::raw(Contract::CREATED_AT),DB::raw(Contract::ANSWERED_AT))
            ->where([
                [Contract::IS_PAID,true],
                [Contract::STATUS,2]
            ])
            ->whereBetween(Contract::CREATED_AT, [$start.' 00:00:00',$end.' 23:59:59'])
            ->get();
        return self::getQuestion($questions);
    }

    /**
     * @throws Exception
     */
    public static function countDateAverageBetweenClosed($lawyerId, $start, $end): array
    {
        $questions  =   Question::select(DB::raw(Contract::CREATED_AT),DB::raw(Contract::ANSWERED_AT))
            ->where([
                [Contract::LAWYER_ID, $lawyerId],
                [Contract::IS_PAID,true],
                [Contract::STATUS,2]
            ])
            ->whereBetween(Contract::CREATED_AT, [$start.' 00:00:00',$end.' 23:59:59'])
            ->get();
        return self::getQuestion($questions);
    }

    public static function countDateLawyerBetweenClosed($lawyerId, $start, $end)
    {
        return Question::select(DB::raw('count(id) as count'),DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where([
                [Contract::LAWYER_ID, $lawyerId],
                [Contract::IS_PAID,true],
                [Contract::STATUS,2]
            ])
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

    /**
     * @throws Exception
     */
    public static function averageTime($where = [])
    {
        $questions  =   Question::select(DB::raw(Contract::CREATED_AT),DB::raw(Contract::ANSWERED_AT))
            ->where($where)
            ->get();
        return self::getQuestion($questions);
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

    /**
     * @param $where
     * @return Builder
     */
    public function getBuilder($where): Builder
    {
        $data = [];
        foreach ($where as $key => $value) {
            if ($key !== Contract::SEARCH && $key !== Contract::LAWYER_ID ) {
                $data[] = [$key, $value];
            }
        }
        $query = $this->model::with('user', 'lawyer')->withoutGlobalScope(IsPaid::class);

        $arr    =   $data;
        if (array_key_exists(Contract::LAWYER_ID, $where)) {
            $query->where(array_merge($arr, [
                [Contract::LAWYER_ID, $where[Contract::LAWYER_ID]]
            ]));
        }
        $arr    =   $data;
        if (array_key_exists(Contract::SEARCH, $where)) {
            $query->orWhere(array_merge($arr, [
                [Contract::LAWYER_ID, $where[Contract::LAWYER_ID]]
            ]));
            $arr    =   $data;
            $query->orWhere(array_merge($arr, [
                [Contract::TITLE, 'like', $where[Contract::SEARCH] . '%']
            ]));
        } else if (array_key_exists(Contract::LAWYER_ID, $where)) {
            $query->orWhere(array_merge($arr,[
                [Contract::LAWYER_ID, null]
            ]));
        } else {
            $query->where($where);
        }
        return $query;
    }
}
