<?php

namespace App\Domain\Helpers;

class Smsc
{
    const URL   =   'https://smsc.kz/sys/send.php';
    const LOGIN =   'needhelp';
    const PASS  =   'Az123456';

    public static function sendCode($phone, $code): void
    {
        Curl::get(self::URL . '?' . self::parameters([
            'phones'    =>  $phone,
            'mes'       =>  'NeedHelp Ваш код: '.$code
        ]));
    }

    public static function parameters(array $data): string
    {
        $arr    =   array_merge([
            'login' =>  self::LOGIN,
            'psw'   =>  self::PASS,
        ],$data);
        return http_build_query($arr);
    }
}
