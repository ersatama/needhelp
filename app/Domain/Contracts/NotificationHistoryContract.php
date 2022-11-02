<?php

namespace App\Domain\Contracts;

class NotificationHistoryContract extends Contract
{
    const TABLE =   'notification_histories';
    const FILLABLE  =   [
        self::NOTIFICATION_ID,
        self::USER_ID,
        self::MESSAGE,
        self::VIEW,
    ];
}
