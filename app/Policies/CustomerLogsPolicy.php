<?php

namespace App\Policies;

use App\Models\CustomerLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerLogsPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.customer_logs.index'));
    }


    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.customer_logs.destroy'));
    }
}
