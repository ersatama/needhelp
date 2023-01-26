<?php

namespace App\Http\Resources\NotificationGlobal;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class NotificationGlobalCollection extends ResourceCollection
{
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new NotificationGlobalResource($request);
        });
    }
}
