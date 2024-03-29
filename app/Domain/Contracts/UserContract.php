<?php

namespace App\Domain\Contracts;

class UserContract extends Contract
{
    const TABLE =   self::USERS;
    const FILLABLE  =   [
        self::ID,
        self::ROLE,
        self::LANGUAGE_ID,
        self::REGION_ID,
        self::CITY_ID,
        self::NAME,
        self::SURNAME,
        self::LAST_NAME,
        self::GENDER,
        self::BIRTHDATE,
        self::PHONE,
        self::PHONE_CODE,
        self::PHONE_VERIFIED_AT,
        self::EMAIL,
        self::EMAIL_CODE,
        self::EMAIL_VERIFIED_AT,
        self::PASSWORD,
        self::REMEMBER_TOKEN,
        self::PUSH_NOTIFICATION,
        self::BLOCKED_AT,
        self::BLOCKED_REASON,
        self::LAST_AUTH,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT
    ];
    const HIDDEN    =   [

    ];
    const DATES =   [
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT
    ];
    const CASTS =   [

    ];
    const APPENDS   =   [
        self::FULLNAME
    ];
    const SEARCH    =   [
        self::ID,
        self::NAME,
        self::SURNAME,
        self::LAST_NAME,
        self::EMAIL,
        self::PHONE
    ];
}
