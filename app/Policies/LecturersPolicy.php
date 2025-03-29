<?php

namespace App\Policies;

use App\Models\Lecturers;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LecturersPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.lecturers.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.lecturers.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.lecturers.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.lecturers.destroy'));
    }
}
