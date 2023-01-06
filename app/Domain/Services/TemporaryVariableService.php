<?php

namespace App\Domain\Services;

use App\Domain\Repositories\TemporaryVariable\TemporaryVariableRepositoryInterface;

class TemporaryVariableService extends Service
{
    public TemporaryVariableRepositoryInterface $temporaryVariableRepository;
    public function __construct(TemporaryVariableRepositoryInterface $temporaryVariableRepository)
    {
        $this->temporaryVariableRepository  =   $temporaryVariableRepository;
    }
}
