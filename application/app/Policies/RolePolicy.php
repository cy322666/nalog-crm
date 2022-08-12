<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->hasPermission('view_roles');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->isAdmin() || $user->hasPermission('view_role');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->hasPermission('create_role');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function update(User $user)
    {
        return $user->isAdmin() || $user->hasPermission('update_role');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function delete(User $user)
    {
        return $user->isAdmin() || $user->hasPermission('delete_role');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param User $user
     * @return Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermission('delete_role');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param User $user
     * @return Response|bool
     */
    public function forceDelete(User $user): Response|bool
    {
        return $user->isAdmin() || $user->hasPermission('delete_role');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param User $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->isAdmin() || $user->hasPermission('delete_role');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->isAdmin() || $user->hasPermission('restore_role');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param User $user
     * @return Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermission('restore_any_role');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param User $user
     * @return Response|bool
     */
    public function replicate(User $user)
    {
        return $user->isAdmin() || $user->hasPermission('replicate_role');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param User $user
     * @return Response|bool
     */
    public function reorder(User $user)
    {
        return $user->isAdmin() || $user->hasPermission('reorder_role');
    }

}
