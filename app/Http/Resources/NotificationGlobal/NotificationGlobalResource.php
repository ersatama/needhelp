<?php

namespace App\Http\Resources\NotificationGlobal;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\NotificationGlobalContract;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationGlobalResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
        ];
        foreach (NotificationGlobalContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }
}
