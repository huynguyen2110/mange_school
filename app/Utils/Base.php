<?php

namespace App\Utils;

use Illuminate\Support\Str;

class Base
{
    /**
     * generate uuid
     */
    public static function generateUuid($prefix = null)
    {
        $str = substr(Str::uuid()->getHex(), 0, 20);
        if ($prefix === null) {
            return $str;
        }

        return sprintf("{$prefix}_{$str}");
    }

    public static function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
