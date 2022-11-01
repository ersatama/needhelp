<?php

namespace App\Domain\Services;

use App\Domain\Repositories\City\CityRepositoryInterface;

class CityService extends Service
{
    public CityRepositoryInterface $cityRepository;
    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository   =   $cityRepository;
    }
}
