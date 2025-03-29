<?php

namespace App\Policies;

use App\Models\Tax;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxPolicy
{
    use HandlesAuthorization;


    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.taxes.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.taxes.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.taxes.edit'));
    }


    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.taxes.destroy'));
    }
}
