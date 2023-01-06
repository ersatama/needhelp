<?php

namespace App\Domain\Contracts;

class WooppayContract extends Contract
{
    const TABLE =   'wooppays';
    const FILLABLE  =   [
        self::QUESTION_ID,
        self::OPERATION_ID,
        self::REPLENISHMENT_ID,
        self::INVOICE_ID,
        self::KEY,
        self::URL,
        self::STATUS
    ];
}
