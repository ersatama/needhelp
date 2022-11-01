<?php

namespace App\Domain\Services;

use App\Domain\Repositories\Country\CountryRepositoryInterface;

class CountryService extends Service
{
    public CountryRepositoryInterface $countryRepository;
    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository    =   $countryRepository;
    }
}
