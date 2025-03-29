<?php

namespace App\Policies;

use App\Models\QuizCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizCategoryPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quiz_categories.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quiz_categories.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quiz_categories.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quiz_categories.destroy'));
    }
}
