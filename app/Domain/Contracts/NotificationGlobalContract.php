<?php

namespace App\Domain\Contracts;

class NotificationGlobalContract extends Contract
{
    const TABLE =   'notification_globals';
    const FILLABLE  =   [
        self::ROLE,
        self::TEXT,
        self::TEXT_KZ,
        self::TEXT_EN
    ];
}
