<?php 

namespace App\Traits\ModelHelper;

use App\Enums\RequestStatusEnum;

trait HasRequestStatus {
    public function is_draft() : bool
    {
        return ($this->status == RequestStatusEnum::DRAFT->value) ? true : false;
    }
    public function is_end(): bool
    {
        switch ($this->status) {
            case RequestStatusEnum::END_ACCEPT->value:
            case RequestStatusEnum::END_DELEVERED->value:
            case RequestStatusEnum::END_REJECTED->value:
            case RequestStatusEnum::TIMEOUT->value:
            case RequestStatusEnum::END_UNDER_DELIVERY->value:
            case RequestStatusEnum::REJECTED->value:
                return true;
                break;
            default:
                return false;
                break;
        }
    }
}



