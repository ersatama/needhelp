<?php

namespace App\Domain\Scopes;

use App\Domain\Contracts\Contract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IsPaid implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where(Contract::IS_PAID,true);
    }
}
