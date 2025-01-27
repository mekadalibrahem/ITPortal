<?php
namespace App\Enums ;

enum RequestStatusEnum : string {
    case DRAFT  = 'draft'  ;
    case CHECKING = "checking";
    case DELETED = "deleted" ;
    case WATING = 'wating' ;
    case TIMEOUT ='timeout' ;
    case WORKING ='working' ;
    case REJECTED = 'rejected' ;
    case END_REJECTED = 'end_rejected' ;
    case END_ACCEPT = 'accept' ;
    case END_UNDER_DELIVERY = 'under delivery' ;
    case END_DELEVERED = 'delevered' ;

}


