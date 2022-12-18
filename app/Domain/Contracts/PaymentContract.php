<?php

namespace App\Domain\Contracts;

class PaymentContract extends Contract
{
    const TABLE =   'payments';
    const FILLABLE  =   [
        self::TITLE,
        self::LOGIN,
        self::PASSWORD,
    ];
    const HIDE  =   [
        self::LOGIN,
        self::PASSWORD,
    ];
}
