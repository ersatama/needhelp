<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\CountryService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Country\CountryCollection;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected CountryService $countryService;
    public function __construct(CountryService $countryService)
    {
        $this->countryService   =   $countryService;
    }

    /**
     * get - Country
     *
     * @group Country
     */
    public function get(): CountryCollection
    {
        return new CountryCollection($this->countryService->countryRepository->get());
    }
}
