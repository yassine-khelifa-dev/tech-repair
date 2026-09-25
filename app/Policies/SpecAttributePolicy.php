<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\SpecAttribute;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpecAttributePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::TECHNICIAN;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SpecAttribute $specAttribute): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::TECHNICIAN;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SpecAttribute $specAttribute): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SpecAttribute $specAttribute): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SpecAttribute $specAttribute): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SpecAttribute $specAttribute): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
