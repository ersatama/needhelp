<?php

namespace App\Domain\Contracts;

class WooppayStatusArchiveContract extends Contract
{
    const TABLE =   'wooppay_status_archives';
    const FILLABLE  = [
        self::OPERATION_ID,
        self::DATA
    ];
}
