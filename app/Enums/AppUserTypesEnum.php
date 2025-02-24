<?php

namespace App\Enums;

enum AppUserTypesEnum: string
{
    case CITIZEN = 'citizen';
    case GULF_CITIZEN = 'gulf_citizen';
    case VISITOR = 'visitor';
}
