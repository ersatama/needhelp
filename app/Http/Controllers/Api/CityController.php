<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\CityService;
use App\Http\Controllers\Controller;
use App\Http\Resources\City\CityCollection;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected CityService $cityService;
    public function __construct(CityService $cityService)
    {
        $this->cityService  =   $cityService;
    }

    /**
     * getByRegionId - City
     *
     * @group City
     */
    public function getByRegionId($countryId): CityCollection
    {
        return new CityCollection($this->cityService->cityRepository->getByRegionId($countryId));
    }
}
