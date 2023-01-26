<?php

namespace App\Domain\Contracts;

class NotificationEventContract extends Contract
{
    const TABLE =   'notification_events';
    const FILLABLE  =   [
        self::QUESTION_ID,
        self::IS_PAID,
        self::STATUS
    ];
}
