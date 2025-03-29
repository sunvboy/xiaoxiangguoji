<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.courses.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.courses.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.courses.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.courses.destroy'));
    }
}
