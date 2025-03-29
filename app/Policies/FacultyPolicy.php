<?php

namespace App\Policies;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacultyPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faculties.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faculties.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faculties.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faculties.destroy'));
    }
}
