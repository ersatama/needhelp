<?php

namespace App\Domain\Contracts;

class PhoneCodeContract extends Contract
{
    const TABLE =   'phone_codes';
    const FILLABLE  =   [
        self::PHONE,
        self::CODE,
    ];
}
