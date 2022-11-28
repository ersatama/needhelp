<?php

namespace App\Domain\Contracts;

class NotificationContract extends Contract
{
    const TABLE =   'notifications';
    const FILLABLE  =   [
        self::USER_ID,
        self::CURRENCY_ID,
        self::PRICE,
        self::TITLE,
        self::DESCRIPTION,
        self::IS_IMPORTANT,
        self::IS_PAID,
        self::STATUS
    ];
}
