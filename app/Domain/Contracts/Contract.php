<?php

namespace App\Domain\Contracts;

abstract class Contract
{
    const VIEW  =   'view';
    const NOTIFICATION_ID   =   'notification_id';
    const IS_PAID   =   'is_paid';
    const IS_IMPORTANT  =   'is_important';
    const STATUS    =   'status';
    const DESCRIPTION   =   'description';
    const REGION_ID =   'region_id';
    const COUNTRY_ID    =   'country_id';
    const TITLE =   'title';
    const REGION    =   'region';
    const TITLE_KZ  =   'title_kz';
    const TITLE_EN  =   'title_en';
    const CITY_ID   =   'city_id';
    const LANGUAGE_ID   =   'language_id';
    const UPDATED_AT    =   'updated_at';
    const CREATED_AT    =   'created_at';
    const BLOCKED_AT    =   'blocked_at';
    const BLOCKED_REASON    =   'blocked_reason';
    const MESSAGE   =   'message';
    const ID    =   'id';
    const USER_ID   =   'user_id';
    const USERS =   'users';
    const NAME  =   'name';
    const ROLE  =   'role';
    const ADMIN =   'admin';
    const LAWYER    =   'lawyer';
    const MANAGER   =   'manager';
    const USER  =   'user';
    const SURNAME   =   'surname';
    const LAST_NAME =   'last_name';
    const GENDER    =   'gender';
    const MALE  =   'male';
    const FEMALE    =   'female';
    const BIRTHDATE =   'birthdate';
    const PHONE =   'phone';
    const PHONE_CODE    =   'phone_code';
    const PHONE_VERIFIED_AT =   'phone_verified_at';
    const EMAIL =   'email';
    const EMAIL_CODE    =   'email_code';
    const EMAIL_VERIFIED_AT =   'email_verified_at';
    const PASSWORD  =   'password';
    const REMEMBER_TOKEN    =   'remember_token';
    const LANGUAGE  =   'language';
    const PUSH_NOTIFICATION =   'push_notification';
}
