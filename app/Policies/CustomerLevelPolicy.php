<?php

namespace App\Policies;

use App\Models\CustomerLevel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerLevelPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.customer_levels.index'));
    }
}
