<?php

namespace App\Domain\Helpers;

class Curl
{
    public static function get(string $link): bool|string
    {
        $ch     =   curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $exec   =   curl_exec($ch);
        curl_close($ch);
        return $exec;
    }

    public static function withOpt($options): bool|string
    {
        $curl       =   curl_init();
        curl_setopt_array($curl, $options);
        $response   =   curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
