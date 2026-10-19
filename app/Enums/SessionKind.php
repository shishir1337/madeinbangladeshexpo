<?php

namespace App\Enums;

enum SessionKind: string
{
    case Setup = 'setup';
    case Press = 'press';
    case Ceremony = 'ceremony';
    case Seminar = 'seminar';
    case Matchmaking = 'matchmaking';
    case Networking = 'networking';

    public function label(): string
    {
        return __("pages/archive.kinds.{$this->value}");
    }

    public function icon(): string
    {
        return match ($this) {
            self::Setup => 'store',
            self::Press => 'megaphone',
            self::Ceremony => 'award',
            self::Seminar => 'mic',
            self::Matchmaking => 'puzzle',
            self::Networking => 'users',
        };
    }
}
