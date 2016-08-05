<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Kalnoy\Nestedset\NodeTrait;

use Hash;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_USER = 'USER';

    
    use NodeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Установить руководителя данному пользователю.
     * $headId - id пользователя (руководителя).
     */
    public function setHead($headId)
    {
        // Не будет обновлять положение в дереве, если пользователь не менял его.
        $currentId = $this->getCurrentHeadId();
        if ($currentId == $headId) {
            return;
        }

        $newHeadUser = User::find($headId);

        if ($newHeadUser == null) {
            $this->makeRoot();
        } else {
            $this->appendToNode($newHeadUser);
        }
    }

    /**
     * Задать пароль пользователю.
     */
    public function setPassword($password)
    {
        $this->password = Hash::make($password);
    }

    /**
     * Получить список руководителей.
     */
    public static function getHeads($user)
    {
        if ($user != null) {
            $heads = User::whereNotDescendantOf($user)->lists('name', 'id');
        } else {
            $heads = User::lists('name', 'id');
        }

        $heads[''] = '--- Руководитель не указан ---';
        return $heads;
    }
    
    public static function getRoles() {
        return [self::ROLE_USER => 'Пользователь', self::ROLE_ADMIN => 'Администратор'];
    }

    public function setRole($role) {
        $this->role = $role;
    }


    /**
     * Получить id руководителя данного пользователя.
     * id или '', если руководителя нет.
     */
    public function getCurrentHeadId()
    {
        $head = $this->parent()->first();
        if ($head == null) {
            return '';
        } else {
            return $head->id;
        }
    }

    public function getCurrentRoleId() {
        return $this->role;
    }

    /*
     * Получить список исполнителей для автора задачи.
     */
    public static function getResponsibles($user)
    {
        $responsibles = $user->children()->get()->prepend(Auth::user())->lists('name', 'id');
        return $responsibles;

    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Имеет ли пользователь роль "Администратор".
     */
    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }
    
    /**
     * Является ли пользователь автором задачи.
     */
    public function isAuthorTask($task) {
        return $this->id == $task->getAuthorId();
    } 
}
