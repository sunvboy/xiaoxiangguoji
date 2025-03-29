<?php

namespace App\Policies;

use App\Models\ReceiptVouchers;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceiptVouchersPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.receipt_vouchers.index'));
    }


    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.receipt_vouchers.create'));
    }


    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.receipt_vouchers.edit'));
    }


    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.receipt_vouchers.destroy'));
    }
}
