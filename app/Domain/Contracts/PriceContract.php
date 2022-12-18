<?php

namespace App\Domain\Contracts;

class PriceContract extends Contract
{
    const TABLE =   'prices';
    const FILLABLE  =   [
        self::CURRENCY_ID,
        self::PRICE,
        self::IMPORTANT_PRICE
    ];
    const HIDE  =   [
        self::CURRENCY_ID
    ];
}
