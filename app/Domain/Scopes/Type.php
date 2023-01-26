<?php

namespace App\Domain\Scopes;

use App\Domain\Contracts\Contract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Type implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (request()->has(Contract::TYPE)) {
            $type   =   (int) request()->input(Contract::TYPE);
            $builder->where(Contract::TYPE, $type);
        }
    }
}
