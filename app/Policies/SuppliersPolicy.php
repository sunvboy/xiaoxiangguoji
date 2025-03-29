<?php

namespace App\Policies;

use App\Models\Suppliers;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuppliersPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.suppliers.index'));
    }
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.suppliers.create'));
    }
    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.suppliers.edit'));
    }
    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.suppliers.destroy'));
    }
}
