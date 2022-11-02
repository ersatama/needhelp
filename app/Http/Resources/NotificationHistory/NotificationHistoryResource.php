<?php

namespace App\Http\Resources\NotificationHistory;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\NotificationHistoryContract;
use App\Models\NotificationHistory;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationHistoryResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
        ];
        foreach (NotificationHistoryContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }
}
