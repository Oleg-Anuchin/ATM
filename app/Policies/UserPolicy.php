<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Task;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Может ли пользователь использовать административную часть.
     * @param User $user
     * @return bool
     */
    public function useAdmin(User $user) {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Может ли пользователь редактировать задачу.
     */
    public function editTask(User $user, Task $task) {
        return $user->isAuthorTask($task);
    }
}
