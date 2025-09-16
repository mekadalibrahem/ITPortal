<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Masmerise\Toaster\Toaster;

class UserPolicy
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
    public function view(User $user, User $model): bool
    {
        return true;
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
    public function update(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $loggedInUser, User $userToDelete): bool
    {

        if (! $userToDelete->hasRole('admin')) {
            return true;
        }

        if (! $loggedInUser->hasRole('admin')) {
            return false;
        }


        $otherAdminsCount = User::role('admin')
            ->where('id', '!=', $userToDelete->id)
            ->count();


        if ($otherAdminsCount < 1) {
            Toaster::warning(trans("messages.YOU CANNOT DELETE LAST ADMIN SHOULD ADD ANOTHER ADMIN BEFOR DELETE THIS ONE"));
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $loggedInUser, User $userToDelete): bool
    {
        if (! $userToDelete->hasRole('admin')) {
            return true;
        }

        if (! $loggedInUser->hasRole('admin')) {
            return false;
        }


        $otherAdminsCount = User::role('admin')
            ->where('id', '!=', $userToDelete->id)
            ->count();


        if ($otherAdminsCount < 1) {
            Toaster::warning(trans("messages.YOU CANNOT DELETE LAST ADMIN SHOULD ADD ANOTHER ADMIN BEFOR DELETE THIS ONE"));
            return false;
        }

        return true;
    }
}
