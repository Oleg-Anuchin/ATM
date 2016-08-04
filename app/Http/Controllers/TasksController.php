<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
   
    public function create (Request $request) {

       $responsibles = User::getResponsibles(Auth::user());
        return view('tasks.new')
            ->with('responsibles', $responsibles)
            ->with('isNewMode', true)
            ->with('isEditMode', false)
            ->with('isShowMode', false);

    }

    public function edit(Request $request, $id) {
        $user = User::findOrFail($id);
        $currentHeadId = $user->getCurrentHeadId();
        $heads = $user->getHeads($user);
        return view('admin.newUser')
            ->with('isEditMode', true)
            ->with('user', $user)
            ->with('heads', $heads)
            ->with('currentHeadId', $currentHeadId);
    }

    public function store(Request $request) {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->setPassword($request->password);
        $user->setHead($request->input('head'));
        $user->save();

        return Redirect::route('admin.user.index');
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        if ($request->input('password'))
            $user->setPassword($request->password);
        $user->setHead($request->input('head'));

        $user->save();

        return Redirect::route('admin.user.index');
    }

}
