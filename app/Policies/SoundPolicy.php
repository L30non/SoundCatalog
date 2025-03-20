<?php

namespace App\Policies;

use App\Models\Sound;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SoundPolicy
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
    public function view(User $user, Sound $sound): bool
    {
        return $sound->status === 'approved';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isCreator() || $user->isAdmin() || $user->isUser();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sound $sound): bool
    {
        return $user->id === $sound->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sound $sound): bool
    {
        return $user->id === $sound->user_id || $user->isAdmin();
    }

    public function approve(User $user,Sound $sound){
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Sound $sound): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Sound $sound): bool
    {
        return false;
    }
}
