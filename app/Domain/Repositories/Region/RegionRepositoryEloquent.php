<?php

namespace App\Domain\Repositories\Region;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Region;

class RegionRepositoryEloquent implements RegionRepositoryInterface
{
    use RepositoryEloquent;
    protected Region $model;
    public function __construct(Region $region)
    {
        $this->model    =   $region;
    }
}
