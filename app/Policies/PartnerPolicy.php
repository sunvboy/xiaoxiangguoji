<?php

namespace App\Policies;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.partners.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.partners.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.partners.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.partners.destroy'));
    }
}
