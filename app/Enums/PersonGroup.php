<?php

namespace App\Enums;

enum PersonGroup: string
{
    case Patron = 'patron';
    case Leadership = 'leadership';
    case Board = 'board';
    case Team = 'team';

    public function label(): string
    {
        return __("pages/committee.groups.{$this->value}");
    }
}
