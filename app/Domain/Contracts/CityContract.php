<?php

namespace App\Domain\Contracts;

class CityContract extends Contract
{
    const TABLE =   'cities';
    const FILLABLE  =   [
        self::REGION_ID,
        self::TITLE,
        self::TITLE_KZ,
        self::TITLE_EN,
    ];
}
