<?php

namespace App\Domain\Repositories\Wooppay;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Wooppay;

class WooppayRepositoryEloquent implements WooppayRepositoryInterface
{
    use RepositoryEloquent;
    protected Wooppay $model;
    public function __construct(Wooppay $wooppay)
    {
        $this->model    =   $wooppay;
    }
}
