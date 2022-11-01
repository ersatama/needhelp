<?php

namespace App\Domain\Contracts;

class CountryContract extends Contract
{
    const TABLE =   'countries';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::TITLE_EN,
    ];
}
