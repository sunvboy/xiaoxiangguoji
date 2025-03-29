<?php

namespace App\Policies;

use App\Models\Recruitments;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecruitmentsPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.recruitments.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.recruitments.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.recruitments.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.recruitments.destroy'));
    }
}
