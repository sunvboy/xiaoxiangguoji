<?php

namespace App\Policies;

use App\Models\PaymentVouchers;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentVouchersPolicy
{
    use HandlesAuthorization;




    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.payment_vouchers.index'));
    }


    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.payment_vouchers.create'));
    }


    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.payment_vouchers.edit'));
    }


    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.payment_vouchers.destroy'));
    }
}
