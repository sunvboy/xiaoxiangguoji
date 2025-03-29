<?php

namespace App\Policies;

use App\Models\OrderOnline;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderOnlinePolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.order_onlines.index'));
    }
    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.order_onlines.destroy'));
    }
}
