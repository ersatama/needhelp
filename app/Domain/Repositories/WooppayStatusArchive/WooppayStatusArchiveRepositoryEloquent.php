<?php

namespace App\Domain\Repositories\WooppayStatusArchive;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\WooppayStatusArchive;

class WooppayStatusArchiveRepositoryEloquent implements WooppayStatusArchiveRepositoryInterface
{
    use RepositoryEloquent;
    protected WooppayStatusArchive $model;
    public function __construct(WooppayStatusArchive $wooppayStatusArchive)
    {
        $this->model    =   $wooppayStatusArchive;
    }
}
