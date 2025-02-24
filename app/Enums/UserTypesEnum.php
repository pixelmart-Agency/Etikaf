<?php

namespace App\Enums;

enum UserTypesEnum: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';
}
