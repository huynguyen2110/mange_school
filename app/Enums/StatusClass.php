<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class StatusClass extends Enum
{
    const NOTSTART =   0;
    const START =   1;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::START:
                return 'Đã vào học';
                break;
            case self::NOTSTART:
                return 'Đang đăng kí';
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
