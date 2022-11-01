<?php

namespace App\Domain\Repositories\Country;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Country;

class CountryRepositoryEloquent implements CountryRepositoryInterface
{
    use RepositoryEloquent;
    protected Country $model;
    public function __construct(Country $country)
    {
        $this->model    =   $country;
    }
}
