<?php

namespace App\Domain\Contracts;

class NotificationContract extends Contract
{
    const TABLE =   'notifications';
    const FILLABLE  =   [
        self::USER_ID,
        self::TITLE,
        self::DESCRIPTION,
        self::IS_IMPORTANT,
        self::IS_PAID,
    ];
}
