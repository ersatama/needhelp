<?php

namespace App\Domain\Repositories\PhoneCode;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\PhoneCode;

class PhoneCodeRepositoryEloquent implements PhoneCodeRepositoryInterface
{
    use RepositoryEloquent;
    protected PhoneCode $model;
    public function __construct(PhoneCode $phoneCode)
    {
        $this->model    =   $phoneCode;
    }
}
