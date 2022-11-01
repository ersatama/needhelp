<?php

namespace App\Http\Resources\Country;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\CountryContract;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
        ];
        foreach (CountryContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }
}
