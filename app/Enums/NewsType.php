<?php

namespace App\Enums;

enum NewsType: string
{
    case News = 'news';
    case PressRelease = 'press_release';
    case Coverage = 'coverage';

    public function label(): string
    {
        return __("home.press.types.{$this->value}");
    }
}
