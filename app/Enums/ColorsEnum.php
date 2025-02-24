<?php

namespace App\Enums;

enum ColorsEnum: string
{
    case RED = '#D50B3E';
    case GREEN = '#35685F';
    case PAIGE = '#C8AB80';
    case BROWN = '#8A6100';
    case DARK_GREEN = '#17663A';

    public static function getAll()
    {
        $colors = [];
        foreach (self::cases() as $value) {
            $colors[] = [
                'name' => __('translation.' . $value->name),
                'value' => $value->value
            ];
        }
        return $colors;
    }
}
