<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class GenderType extends Enum
{
    const Women =   0;
    const Men =   1;


    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Women:
                return 'Nữ';
                break;
            case self::Men:
                return 'Nam';
                break;

        }
    }

    public static function parseArray()
    {
        $data = [];
        foreach (self::getValues() as $value) {
            $data[] = ['label' => self::getDescription($value), 'value' => $value];
        }

        return $data;
    }
}
