<?php

namespace App\Policies;

use App\Models\FacultyCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacultyCategoryPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faculty_categories.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faculty_categories.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faculty_categories.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faculty_categories.destroy'));
    }
}
