<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.ships.index'));
    }
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.ships.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.ships.edit'));
    }
    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.ships.destroy'));
    }
}
