<?php

namespace App\Policies;

use App\Models\ProductDeal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductDealPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.product_deals.index'));
    }
    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.product_deals.create'));
    }
    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.product_deals.edit'));
    }
    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.product_deals.destroy'));
    }
}
