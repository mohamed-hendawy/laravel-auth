<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Fort Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Fort Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

namespace Rinvex\Fort\Policies;

use Rinvex\Fort\Models\Role;
use Rinvex\Fort\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the role.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     * @param \Rinvex\Fort\Models\Role $resource
     *
     * @return bool
     */
    public function view($ability, User $user, Role $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     * @param \Rinvex\Fort\Models\Role $resource
     *
     * @return bool
     */
    public function update($ability, User $user, Role $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability)           // User can update roles
               && $user->hasRole($resource)                                     // User already have RESOURCE role
               && ! $resource->isSuperadmin()                                   // RESOURCE role is NOT superadmin
               && ! $resource->isProtected();                                   // RESOURCE role is NOT protected
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     * @param \Rinvex\Fort\Models\Role $resource
     *
     * @return bool
     */
    public function delete($ability, User $user, Role $resource)
    {
        return $resource->abilities->isEmpty()                                  // RESOURCE role has no abilities attached
               && $resource->users->isEmpty()                                   // RESOURCE role has no users attached
               && $user->allAbilities->pluck('slug')->contains($ability)        // User can delete roles
               && $user->allAbilities->pluck('slug')->contains($resource->slug) // User already have RESOURCE role
               && ! $resource->isSuperadmin()                                   // RESOURCE role is NOT superadmin
               && ! $resource->isProtected();                                   // RESOURCE role is NOT protected
    }

    /**
     * Determine whether the user can import the roles.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function import($ability, User $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can export the roles.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function export($ability, User $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can give the role.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     * @param \Rinvex\Fort\Models\Role $resource
     * @param \Rinvex\Fort\Models\User $resourced
     *
     * @return bool
     */
    public function give($ability, User $user, Role $resource, User $resourced)
    {
        return $user->allAbilities->pluck('slug')->contains($ability)           // User can give roles
               && $user->allAbilities->pluck('slug')->contains($resource->slug) // User already have RESOURCE role
               && ! $resourced->isSuperadmin()                                  // RESOURCED user is NOT superadmin
               && ! $resourced->isProtected();                                  // RESOURCED user is NOT protected
    }

    /**
     * Determine whether the user can remove the role.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     * @param \Rinvex\Fort\Models\Role $resource
     * @param \Rinvex\Fort\Models\User $resourced
     *
     * @return bool
     */
    public function remove($ability, User $user, Role $resource, User $resourced)
    {
        return $user->allAbilities->pluck('slug')->contains($ability)           // User can remove roles
               && $user->allAbilities->pluck('slug')->contains($resource->slug) // User already have RESOURCE role
               && ! $resourced->isSuperadmin()                                  // RESOURCED user is NOT superadmin
               && ! $resourced->isProtected();                                  // RESOURCED user is NOT protected
    }
}
