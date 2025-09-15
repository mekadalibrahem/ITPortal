<?php

namespace App\Traits\ModelHelper;

use App\Enums\RequestStatusEnum;

trait HasRequestStatus
{
    public function is_draft(): bool
    {
        return ($this->status == RequestStatusEnum::DRAFT->value) ? true : false;
    }
    public function is_end(): bool
    {
        switch ($this->status) {
            case RequestStatusEnum::END_ACCEPT->value:
            case RequestStatusEnum::REJECTED->value:
                return true;
                break;
            default:
                return false;
                break;
        }
    }
    public function isRejected(): bool
    {
        switch ($this->status) {
            case RequestStatusEnum::REJECTED->value:
                return true;
                break;

            default:
                return false;
                break;
        }
    }
}
