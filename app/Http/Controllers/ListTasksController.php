<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ListTasksController extends Controller
{
    public function myIndex(Request $request) {
        $user = Auth::user();
        $tasks = Task::getMyTasks($user);
        return view('tasks.myself')
            ->with('tasks', $tasks);
    }

    public function forMyselfIndex(Request $request) {
        $user = Auth::user();
        $tasks = Task::getForMyselfTasks($user);
        return view('tasks.myteam')
            ->with('tasks', $tasks);
    }

}
