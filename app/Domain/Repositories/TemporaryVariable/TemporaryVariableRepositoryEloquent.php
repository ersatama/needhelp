<?php

namespace App\Domain\Repositories\TemporaryVariable;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\TemporaryVariable;

class TemporaryVariableRepositoryEloquent implements TemporaryVariableRepositoryInterface
{
    use RepositoryEloquent;
    protected TemporaryVariable $model;
    public function __construct(TemporaryVariable $temporaryVariable)
    {
        $this->model    =   $temporaryVariable;
    }
}
