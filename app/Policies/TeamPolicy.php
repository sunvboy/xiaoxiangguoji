<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.teams.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.teams.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.teams.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.teams.destroy'));
    }
}
