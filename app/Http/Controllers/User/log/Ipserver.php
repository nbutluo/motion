<?php

namespace App\Http\Controllers\User\log;


class Ipserver
{
    public static function getRealIp()
    {
        if (isset($_SERVER['HEADER_X_FORWARDED_FOR'])) {
            request()->setTrustedProxies(request()->getClientIps, \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR);
            $ip = request()->getClientIp();
        } else {
            $ip = request()->getClientIp();
        }

        return $ip;
    }
}
