<?php

namespace App\Policies;

use App\Models\OrderLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderLogPolicy
{
    use HandlesAuthorization;


    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.order_logs.index'));
    }


    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.order_logs.destroy'));
    }
}
