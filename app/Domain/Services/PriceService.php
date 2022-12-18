<?php

namespace App\Domain\Services;

use App\Domain\Repositories\Price\PriceRepositoryInterface;

class PriceService extends Service
{
    public PriceRepositoryInterface $priceRepository;
    public function __construct(PriceRepositoryInterface $priceRepository)
    {
        $this->priceRepository  =   $priceRepository;
    }
}
