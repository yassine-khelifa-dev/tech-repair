<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\DeviceType;
use App\Models\User;

class DeviceTypePolicy
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
    public function view(User $user, DeviceType $deviceType): bool
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
    public function update(User $user, DeviceType $deviceType): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DeviceType $deviceType): bool
    {
        return $user->role === UserRole::ADMIN ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DeviceType $deviceType): bool
    {
        return $user->role === UserRole::ADMIN ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DeviceType $deviceType): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
