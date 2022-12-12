<?php

namespace App\Http\Resources\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\QuestionContract;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
        ];
        foreach (QuestionContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }
}
