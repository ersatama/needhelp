<?php

namespace App\Domain\Scopes;

use App\Domain\Contracts\Contract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrderBy implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (request()->has(Contract::ORDER_BY)) {

            $orderBy    =   request()->input(Contract::ORDER_BY);

            if (request()->has(Contract::ORDER_BY_TYPE) && in_array(request()->input(Contract::ORDER_BY_TYPE),Contract::ORDER_BY_TYPES)) {

                $orderByType    =   request()->input(Contract::ORDER_BY_TYPE);
                $builder->orderBy($orderBy, $orderByType);

            } else {
                $builder->orderBy($orderBy);
            }

        } elseif (request()->has(Contract::ORDER_BY_TYPE) && in_array(request()->input(Contract::ORDER_BY_TYPE),Contract::ORDER_BY_TYPES)) {

            $orderByType    =   request()->input(Contract::ORDER_BY_TYPE);
            $builder->orderBy(Contract::ID,$orderByType);

        }
    }
}
