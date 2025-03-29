<?php

namespace App\Policies;

use App\Models\QuizConfig;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizConfigPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quiz_configs.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quiz_configs.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quiz_configs.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quiz_configs.destroy'));
    }
}
