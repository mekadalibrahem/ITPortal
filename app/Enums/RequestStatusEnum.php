<?php

namespace App\Enums;

enum RequestStatusEnum: string
{
    case DRAFT  = 'draft';
    case DELETED = "deleted";
    case WATING = 'wating';
    case WATING_EDIT = "wating to edit";
    case WORKING = 'working';
    case REJECTED = 'rejected';
    case END_ACCEPT = 'accept';
    // old cases
    // case CHECKING = "checking";
    // case TIMEOUT = 'timeout';
    // case END_REJECTED = 'end_rejected';
    // case END_UNDER_DELIVERY = 'under delivery';
    // case END_DELEVERED = 'delevered';
}
