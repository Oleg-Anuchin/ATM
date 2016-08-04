<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Kalnoy\Nestedset\NodeTrait;

use Hash;


class User extends Authenticatable
{
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

    /*
     * Получить список исполнителей для автора задачи.
     */
    public static function getResponsibles($user)
    {
        $heads = $user->children()->get()->lists('name', 'id');
        return $heads;

    }
}
