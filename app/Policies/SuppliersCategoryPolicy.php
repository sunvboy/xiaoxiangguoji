<?php

namespace App\Policies;

use App\Models\SuppliersCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuppliersCategoryPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.suppliers_categories.index'));
    }
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.suppliers_categories.create'));
    }
    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.suppliers_categories.edit'));
    }
    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.suppliers.destroy'));
    }
}
