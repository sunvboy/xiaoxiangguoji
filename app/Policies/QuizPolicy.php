<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quizzes.index'));
    }

    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quizzes.create'));
    }

    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quizzes.edit'));
    }

    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.quizzes.destroy'));
    }
}
