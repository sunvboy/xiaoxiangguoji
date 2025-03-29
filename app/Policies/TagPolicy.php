<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.tags.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.tags.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.tags.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.tags.destroy'));
    }


    public function restore(User $user, Tag $tag)
    {
        //
    }


    public function forceDelete(User $user, Tag $tag)
    {
        //
    }
}
