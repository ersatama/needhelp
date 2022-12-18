<?php

namespace App\Domain\Contracts;

class ErrorContract extends Contract
{
    const NOT_FOUND =   [
        self::MESSAGE   =>  'not found'
    ];
    const INCORRECT_CODE    =   [
        self::MESSAGE   =>  'incorrect code'
    ];
    const INCORRECT_PASSWORD    =   [
        self::MESSAGE   =>  'incorrect password'
    ];
    const NOT_REGISTERED    =   'not_registered';
    const CODE_SENT =   'code_sent';
    const DELETED   =   'deleted';
    const RESTORED  =   'restored';
    const SMS_NOT_SENT  =   [
        self::MESSAGE   =>  'sms_not_sent'
    ];
}
