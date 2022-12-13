<?php

namespace App\Domain\Repositories\Ip;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Ip;

class IpRepositoryEloquent implements IpRepositoryInterface
{
    use RepositoryEloquent;
    protected Ip $model;
    public function __construct(Ip $ip)
    {
        $this->model    =   $ip;
    }
}
