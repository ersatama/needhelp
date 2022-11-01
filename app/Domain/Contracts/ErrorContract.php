<?php

namespace App\Domain\Contracts;

class ErrorContract extends Contract
{
    const NOT_FOUND =   [
        self::MESSAGE   =>  'incorrect phone or password'
    ];
}
