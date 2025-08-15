<?php

namespace App\Enums;

enum StepRolesEnum: string
{
    use EnumToArray;
    case EMPLOYEE = 'employee';
    case MANAGER = 'manager';
}
