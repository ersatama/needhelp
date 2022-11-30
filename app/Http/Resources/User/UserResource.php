<?php

namespace App\Http\Resources\User;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\UserContract;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        $arr    =   [
            Contract::ID    =>  $this->{Contract::ID},
            Contract::CREATED_AT    =>  $this->{Contract::CREATED_AT},
            Contract::UPDATED_AT    =>  $this->{Contract::UPDATED_AT},
            Contract::FULLNAME  =>  $this->{Contract::FULLNAME},
        ];
        foreach (UserContract::FILLABLE as &$value) {
            $arr[$value]    =   $this->{$value};
        }
        return $arr;
    }
}
