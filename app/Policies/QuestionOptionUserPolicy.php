<?php

namespace App\Policies;

use App\Models\QuestionOptionUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionOptionUserPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.question_option_users.index'));
    }
    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.question_option_users.edit'));
    }
}
