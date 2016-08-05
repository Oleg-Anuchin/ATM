<?php

namespace App\Http\Controllers;


use App\Task;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;

class TasksController extends Controller
{

    public function create(Request $request)
    {
        $responsibles = User::getResponsibles(Auth::user());
        return view('tasks.new')
            ->with('responsibles', $responsibles)
            ->with('isNewMode', true)
            ->with('isEditMode', false)
            ->with('isShowMode', false);
    }

    public function store(Request $request)
    {
        $task = new Task();
        $task->title = $request->input('title');
        $task->setAuthorById(Auth::user()->id);
        $task->setResponsibleById($request->input('responsible'));
        $task->save();

        return Redirect::route('tasks.my.index');
    }

    public function edit(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if (!policy(Auth::user())->editTask(Auth::user(), $task)) {
            abort(403);
        }

        $responsibles = User::getResponsibles(Auth::user());
        return view('tasks.new')
            ->with('responsibles', $responsibles)
            ->with('isNewMode', false)
            ->with('isEditMode', true)
            ->with('isShowMode', false)
            ->with('task', $task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if (!policy(Auth::user())->editTask(Auth::user(), $task)) {
            abort(403);
        }

        $task->title = $request->input('title');
        $task->setResponsibleById($request->input('responsible'));
        $task->save();

        return Redirect::route('tasks.my.index');
    }

    public function show(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.new')
            ->with('isNewMode', false)
            ->with('isEditMode', false)
            ->with('isShowMode', true)
            ->with('task', $task);
    }

}
