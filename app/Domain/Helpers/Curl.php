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

    public function getUrl(string $url): bool|string
    {
        $curl   =   curl_init();
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $exec   =   curl_exec($curl);
        curl_close($curl);
        return $exec;
    }

    public function post(string $url, array $header, array $fields): bool|string
    {
        $curl   =   curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
