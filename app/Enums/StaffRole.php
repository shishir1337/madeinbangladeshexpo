<?php

namespace App\Enums;

/**
 * BBCCI console roles (spec §5J). Each case is a spatie/laravel-permission role name on the web guard.
 */
enum StaffRole: string
{
    case SuperAdmin = 'super_admin';
    case Sales = 'sales';
    case Finance = 'finance';
    case VisaDesk = 'visa_desk';
    case LetterSignatory = 'letter_signatory';
    case ContentEditor = 'content_editor';
    case CheckInOperator = 'check_in_operator';
    case Viewer = 'viewer';
}
