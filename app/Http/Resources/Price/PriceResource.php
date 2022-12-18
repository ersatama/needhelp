<?php

namespace App\Http\Resources\Price;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\PriceContract;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
        ];
        foreach (PriceContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        foreach (PriceContract::HIDE as &$value) {
            if (array_key_exists($value,$arr)) {
                unset($arr[$value]);
            }
        }
        return $arr;
    }
}
