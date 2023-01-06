<?php

namespace App\Domain\Contracts;

class TemporaryVariableContract extends Contract
{
    const TABLE =   'temporary_variables';
    const FILLABLE  =   [
        self::KEY,
        self::VALUE,
        self::EXPIRE_AT
    ];
}
