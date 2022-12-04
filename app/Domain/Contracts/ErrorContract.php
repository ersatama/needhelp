<?php

namespace App\Domain\Contracts;

class ErrorContract extends Contract
{
    const NOT_FOUND =   [
        self::MESSAGE   =>  'incorrect phone or password'
    ];
    const INCORRECT_CODE    =   [
        self::MESSAGE   =>  'incorrect code'
    ];
    const INCORRECT_PASSWORD    =   [
        self::MESSAGE   =>  'incorrect password'
    ];
}
