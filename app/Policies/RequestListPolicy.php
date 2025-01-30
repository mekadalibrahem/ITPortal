<?php

namespace App\Policies;

use App\Enums\RequestStatusEnum;
use App\Models\RequestList;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RequestListPolicy
{

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RequestList $requestList): bool
    {
        return ($user->id == $requestList->user_id) ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RequestList $requestList): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RequestList $requestList): bool
    {
        Log::info("$requestList->status  , " . RequestStatusEnum::DRAFT->value);
        if ($user->id != $requestList->user_id) {
            // user can delete just his requests list itmes
            return false;
        }
        if ($requestList->status == RequestStatusEnum::DRAFT->value) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RequestList $requestList): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RequestList $requestList): bool
    {
        return true;
    }
}
