<?php

namespace App\Domain\Services;

use App\Domain\Repositories\Ip\IpRepositoryInterface;

class IpService extends Service
{
    public IpRepositoryInterface $ipRepository;
    public function __construct(IpRepositoryInterface $ipRepository)
    {
        $this->ipRepository =   $ipRepository;
    }
}
