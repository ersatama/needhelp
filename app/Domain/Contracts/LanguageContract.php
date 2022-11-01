<?php

namespace App\Domain\Contracts;

class LanguageContract extends Contract
{
    const TABLE =   'languages';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::TITLE_EN,
    ];
}
