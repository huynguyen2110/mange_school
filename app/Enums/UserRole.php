<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const Admin =   0;
    const Teacher =   1;
    const Student = 2;
    const Guest = 3;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Admin:
                return 'Admin';
                break;
            case self::Teacher:
                return 'Giáo viên';
                break;
            case self::Student:
                return 'Sinh viên';
                break;
            case self::Guest:
                return 'Khách';
                break;
            default:
                return '';
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
