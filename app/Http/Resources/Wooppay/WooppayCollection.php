<?php

namespace App\Http\Resources\Wooppay;

use App\Models\Wooppay;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WooppayCollection extends ResourceCollection
{
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new WooppayResource($request);
        });
    }
}
