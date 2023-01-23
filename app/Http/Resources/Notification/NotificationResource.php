<?php

namespace App\Http\Resources\Notification;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\NotificationContract;
use App\Http\Resources\NotificationGlobal\NotificationGlobalResource;
use App\Http\Resources\Question\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
            Contract::QUESTION  =>  new QuestionResource($this->{Contract::QUESTION}),
            Contract::NOTIFICATION_GLOBAL   =>  new NotificationGlobalResource($this->{Contract::NOTIFICATION_GLOBAL})
        ];
        foreach (NotificationContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }
}
