<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.schedules.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.schedules.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.schedules.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.schedules.destroy'));
    }
}
