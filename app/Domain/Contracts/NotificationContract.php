<?php

namespace App\Domain\Contracts;

class NotificationContract extends Contract
{
    const TABLE = 'notifications';
    const FILLABLE  =   [
        self::USER_ID,
        self::TYPE,
        self::QUESTION_ID,
        self::STATUS,
    ];
}
