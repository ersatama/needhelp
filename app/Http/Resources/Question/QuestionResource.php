<?php

namespace App\Http\Resources\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\QuestionContract;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Wooppay\WooppayResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
            Contract::USER  =>  new UserResource($this->{Contract::USER}),
            Contract::LAWYER    =>  new UserResource($this->{Contract::LAWYER}),
            Contract::TIMER_TEXT    =>  null,
            Contract::WOOPPAY   =>  new WooppayResource($this->{Contract::WOOPPAY})
        ];
        if (request()->has(Contract::TIMEZONE)) {
            $arr[Contract::TIMEZONE_TIMER]    =   Carbon::createFromTimestamp(strtotime($this->{Contract::CREATED_AT}))
                ->timezone(request()->input(Contract::TIMEZONE))
                ->toDateTimeString();
            $arr[Contract::TIMEZONE]    =   Carbon::createFromTimestamp(strtotime($this->{Contract::UPDATED_AT}))
                ->timezone(request()->input(Contract::TIMEZONE))
                ->toDateTimeString();
            $arr[Contract::CREATED_AT]  =   Carbon::createFromTimestamp(strtotime($this->{Contract::CREATED_AT}))
                ->timezone(request()->input(Contract::TIMEZONE))
                ->toDateTimeString();
            $arr[Contract::UPDATED_AT]  =   Carbon::createFromTimestamp(strtotime($this->{Contract::UPDATED_AT}))
                ->timezone(request()->input(Contract::TIMEZONE))
                ->toDateTimeString();
        }
        $arr[Contract::CREATED_AT_READABLE] =   $this->convertDatetime($arr[Contract::CREATED_AT]);
        $arr[Contract::UPDATED_AT_READABLE] =   $this->convertDatetime($arr[Contract::UPDATED_AT]);
        foreach (QuestionContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }

    public function convertDatetime($datetime): string
    {
        $data   =   explode(' ', $datetime);
        $date   =   explode('-', $data[0]);
        $time   =   explode(':', $data[1]);
        return $time[0] . ':' . $time[1] . ' ' . $date[2] . '.' . $date[1] . '.' . $date[0];
    }
}
