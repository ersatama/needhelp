<?php

namespace App\Domain\Services;

use App\Domain\Repositories\WooppayStatusArchive\WooppayStatusArchiveRepositoryInterface;

class WooppayArchiveService extends Service
{
    public WooppayStatusArchiveRepositoryInterface $wooppayStatusArchiveRepository;
    public function __construct(WooppayStatusArchiveRepositoryInterface $wooppayStatusArchiveRepository)
    {
        $this->wooppayStatusArchiveRepository   =   $wooppayStatusArchiveRepository;
    }
}
