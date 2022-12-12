<?php

namespace App\Domain\Scopes;

use App\Domain\Contracts\Contract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Page implements Scope
{
    protected int $take =   10;
    public function apply(Builder $builder, Model $model)
    {
        if (request()->has(Contract::TAKE)) {
            $this->take =   (int) request()->input(Contract::TAKE);
        }
        if (request()->has(Contract::PAGE)) {
            $page   =   (int) request()->input(Contract::PAGE) - 1;
            $builder->skip(($this->take * $page))->take($this->take);
        } else {
            $builder->take($this->take);
        }
    }
}
