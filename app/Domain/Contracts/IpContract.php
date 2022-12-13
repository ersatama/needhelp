<?php

namespace App\Domain\Contracts;

class IpContract extends Contract
{
    const TABLE =   'ips';
    const FILLABLE  =   [
        self::IP,
        self::TITLE,
        self::STATUS
    ];
}
