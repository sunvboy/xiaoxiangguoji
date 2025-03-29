<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.questions.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.questions.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.questions.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.questions.destroy'));
    }
}
