<?php

namespace App\Policies;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.deals.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.deals.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.deals.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.deals.destroy'));
    }
}
