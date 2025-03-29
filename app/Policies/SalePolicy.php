<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalePolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.sales.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.sales.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.sales.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.sales.destroy'));
    }
}
