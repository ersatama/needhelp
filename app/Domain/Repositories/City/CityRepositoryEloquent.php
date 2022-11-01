<?php

namespace App\Domain\Repositories\City;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\City;

class CityRepositoryEloquent implements CityRepositoryInterface
{
    use RepositoryEloquent;
    protected City $model;
    public function __construct(City $city)
    {
        $this->model    =   $city;
    }
}
