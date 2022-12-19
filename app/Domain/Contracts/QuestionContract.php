<?php

namespace App\Domain\Contracts;

class QuestionContract extends Contract
{
    const TABLE =   'questions';
    const FILLABLE  =   [
        self::USER_ID,
        self::LAWYER_ID,
        self::CURRENCY_ID,
        self::PAYMENT_ID,
        self::PRICE,
        self::TITLE,
        self::DESCRIPTION,
        self::ANSWER,
        self::IS_IMPORTANT,
        self::IS_PAID,
        self::STATUS,
        self::IS_NEW,
        self::ANSWERED_AT,
    ];
    const APPENDS   =   [
        self::TIMER
    ];
}
