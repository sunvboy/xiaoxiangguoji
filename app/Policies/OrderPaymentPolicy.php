<?php

namespace App\Policies;

use App\Models\OrderPayment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPaymentPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.orders_payment.index'));
    }
}
