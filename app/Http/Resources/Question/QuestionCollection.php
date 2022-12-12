<?php

namespace App\Http\Resources\Question;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionCollection extends ResourceCollection
{
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new QuestionResource($request);
        });
    }
}
