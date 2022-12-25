<?php

namespace App\Domain\Contracts;

abstract class Contract
{
    const TIMER =   'timer';
    const ORDER_BY_TYPES    =   [
        self::ASC,
        self::DESC
    ];
    const ASC   =   'asc';
    const ORDER_BY_TYPE =   'order_by_type';
    const ORDER_BY  =   'order_by';
    const QUESTION_ID   =   'question_id';
    const DESC  =   'desc';
    const IP    =   'ip';
    const G_RECAPTCHA_RESPONSE  =   'g-recaptcha-response';
    const TAKE  =   'take';
    const SUCCESS   =   'success';
    const IS_NEW    =   'is_new';
    const DATE  =   'date';
    const COUNT =   'count';
    const DATA  =   'data';
    const READONLY  =   'readonly';
    const LIKE  =   'like';
    const Q =   'q';
    const PAGE  =   'page';
    const SELECT_FROM_ARRAY =   'select_from_array';
    const VIEW  =   'view';
    const NOTIFICATION_ID   =   'notification_id';
    const IS_PAID   =   'is_paid';
    const IS_IMPORTANT  =   'is_important';
    const STATUS    =   'status';
    const CODE  =   'code';
    const DESCRIPTION   =   'description';
    const CURRENCY_ID   =   'currency_id';
    const PAYMENT_ID    =   'payment_id';
    const ANSWER    =   'answer';
    const ANSWERED_AT   =   'answered_at';
    const PRICE =   'price';
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
    const CREATED_AT_READABLE   =   'created_at_readable';
    const DELETED_AT    =   'deleted_at';
    const BLOCKED_AT    =   'blocked_at';
    const QUESTION  =   'question';
    const BLOCKED_REASON    =   'blocked_reason';
    const LAST_AUTH =   'last_auth';
    const MESSAGE   =   'message';
    const ID    =   'id';
    const USER_ID   =   'user_id';
    const LAWYER_ID =   'lawyer_id';
    const USERS =   'users';
    const NAME  =   'name';
    const LABEL =   'label';
    const TYPE  =   'type';
    const HIDDEN    =   'hidden';
    const TEXT  =   'text';
    const SELECT2_FROM_AJAX =   'select2_from_ajax';
    const ENTITY    =   'entity';
    const PLACEHOLDER   =   'placeholder';
    const MINIMUM_INPUT_LENGTH  =   'minimum_input_length';
    const ATTRIBUTE =   'attribute';
    const DATA_SOURCE   =   'data_source';
    const ROLE  =   'role';
    const FULLNAME  =   'fullname';
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
    const LOGIN =   'login';
    const REMEMBER_TOKEN    =   'remember_token';
    const LANGUAGE  =   'language';
    const PUSH_NOTIFICATION =   'push_notification';
    const IMPORTANT_PRICE   =   'important_price';
}
