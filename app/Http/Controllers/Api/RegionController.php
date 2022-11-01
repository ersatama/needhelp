<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\RegionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Region\RegionCollection;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    protected RegionService $regionService;
    public function __construct(RegionService $regionService)
    {
        $this->regionService    =   $regionService;
    }

    public function getCountryId($countryId): RegionCollection
    {
        return new RegionCollection($this->regionService->regionRepository->getByCountryId($countryId));
    }
}
