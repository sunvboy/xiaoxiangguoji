<?php

namespace App\Policies;

use App\Models\ScheduleCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScheduleCategoryPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.schedule_categories.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.schedule_categories.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.schedule_categories.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.schedule_categories.destroy'));
    }
}
