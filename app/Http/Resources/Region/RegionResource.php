<?php

namespace App\Http\Resources\Region;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\RegionContract;
use App\Models\Region;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
        ];
        foreach (RegionContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }
}
