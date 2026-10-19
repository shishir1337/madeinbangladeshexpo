<?php

namespace App\Enums;

enum EditionStatus: string
{
    case Draft = 'draft';
    case Announced = 'announced';
    case RegistrationOpen = 'registration_open';
    case Closed = 'closed';
    case Archived = 'archived';
}
