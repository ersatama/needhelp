<?php

namespace App\Domain\Contracts;

class RegionContract extends Contract
{
    const TABLE =   'regions';
    const FILLABLE  =   [
        self::COUNTRY_ID,
        self::TITLE,
        self::TITLE_KZ,
        self::TITLE_EN,
    ];
}
