<?php

namespace App\Policies;

use App\Models\ProductPurchase;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPurchasePolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.product_purchases.index'));
    }
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.product_purchases.create'));
    }
    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.product_purchases.edit'));
    }
    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.product_purchases.destroy'));
    }
}
