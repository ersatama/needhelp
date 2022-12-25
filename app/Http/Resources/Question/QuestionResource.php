<?php

namespace App\Http\Resources\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\QuestionContract;
use App\Http\Resources\User\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::CREATED_AT_READABLE   =>  $this->{Contract::CREATED_AT}->diffForHumans(),
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
            Contract::USER  =>  new UserResource($this->{Contract::USER}),
            Contract::LAWYER    =>  new UserResource($this->{Contract::LAWYER})
        ];
        if (request()->has(Contract::TIMEZONE)) {
            $arr[Contract::TIMEZONE]    =   Carbon::createFromTimestamp(strtotime($this->{Contract::UPDATED_AT}))
                ->timezone(request()->input(Contract::TIMEZONE))
                ->toDateTimeString();
        }
        foreach (QuestionContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }
}
