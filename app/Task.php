<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    public static function getMyTasks(User $user)
    {
        return DB::table('tasks')
            //->join('users', 'tasks.responsible_id', '=', 'users.id')
            //->join('users', 'tasks.responsible_id', '=', 'users.id')

            ->join('users', function($join) {
                $join
                    ->on('tasks.responsible_id', '=', 'users.id')
                    ->orOn('tasks.responsible_id', '=', 'users.id');
            })

            //->join('users', 'tasks.author_id', '=', 'users.id')
            ->select('tasks.*', 'users.name')
            ->where('tasks.responsible_id', '=', $user->id)
            ->get();
        
        
    }

}
