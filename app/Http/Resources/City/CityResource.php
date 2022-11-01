<?php

namespace App\Http\Resources\City;

use App\Domain\Contracts\CityContract;
use App\Domain\Contracts\Contract;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
        ];
        foreach (CityContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }
}
