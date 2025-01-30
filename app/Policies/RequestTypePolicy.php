<?php

namespace App\Policies;

use App\Models\RequestType;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RequestTypePolicy
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
    public function view(User $user, RequestType $requestType): bool
    {

        if ($user->can('request_types.view.*')) {

            return true;
        } elseif ($user->can("request_types.view.$requestType->type")) {

            return true;
        } else {
            
            return false;
        }
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
    public function update(User $user, RequestType $requestType): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RequestType $requestType): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RequestType $requestType): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RequestType $requestType): bool
    {
        return true;
    }


    // public static function fillter_allowed_view($requestTypes)
    // {
    //     $allowed = [];
    //     foreach ($requestTypes as $type) {

    //         if (Gate::allows('view', $type)) {
    //             $allowed[] = $type;
    //         }

    //     }
    //     return $allowed;
    // }
}
