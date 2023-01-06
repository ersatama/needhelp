<?php

namespace App\Domain\Contracts;

class ErrorContract extends Contract
{
    const ERROR_PAYMENT =   [
        self::MESSAGE   =>  'payment error'
    ];
    const ERROR =   [
        self::MESSAGE   =>  'something goes wrong'
    ];
    const QUESTION_ALREADY_ANSWERED =   [
        self::MESSAGE   =>  'question already answered'
    ];
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
