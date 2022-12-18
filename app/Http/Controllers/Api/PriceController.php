<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\PriceService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Price\PriceCollection;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    protected PriceService $priceService;
    public function __construct(PriceService $priceService)
    {
        $this->priceService =   $priceService;
    }

    /**
     * get - Price
     *
     * @group Price
     */
    public function get(): PriceCollection
    {
        return new PriceCollection($this->priceService->priceRepository->get());
    }
}
