<?php

namespace App\Policies;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faqs.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faqs.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faqs.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.faqs.destroy'));
    }
}
