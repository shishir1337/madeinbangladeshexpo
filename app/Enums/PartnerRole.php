<?php

namespace App\Enums;

enum PartnerRole: string
{
    case Organiser = 'organiser';
    case Supporter = 'supporter';
    case Institutional = 'institutional';
    case Media = 'media';

    public function label(): string
    {
        return __("home.partners.roles.{$this->value}");
    }
}
