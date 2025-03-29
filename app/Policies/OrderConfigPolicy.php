<?php

namespace App\Policies;

use App\Models\User;
use App\Models\orderConfig;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderConfigPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.order_configs.index'));
    }
}
