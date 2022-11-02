<?php

namespace App\Http\Resources\NotificationHistory;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationHistoryCollection extends ResourceCollection
{
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new NotificationHistoryResource($request);
        });
    }
}
