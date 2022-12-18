<?php

namespace App\Domain\Repositories\Price;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Price;

class PriceRepositoryEloquent implements PriceRepositoryInterface
{
    use RepositoryEloquent;
    protected Price $model;
    public function __construct(Price $price)
    {
        $this->model    =   $price;
    }
}
