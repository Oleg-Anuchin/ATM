<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Hash;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    public function index(Request $request) {
        $users = User::all();
        return view('admin.index')
            ->with('users', $users)
            ->with('staffTree', User::get()->toTree());
    }

    public function newUser(Request $request) {
        $heads = User::getHeads(null);
        return view('admin.newUser')
            ->with('heads', $heads)
            ->with('isEditMode', false);
        
    }

    public function editUser(Request $request, $id) {
        $user = User::findOrFail($id);
        $currentHeadId = $user->getCurrentHeadId();
        $heads = $user->getHeads($user);
        return view('admin.newUser')
            ->with('isEditMode', true)
            ->with('user', $user)
            ->with('heads', $heads)
            ->with('currentHeadId', $currentHeadId);
    }

    public function storeUser(Request $request) {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->setPassword($request->password);
        $user->setHead($request->input('head'));
        $user->save();

        return Redirect::route('admin.user.index');
    }

    public function updateUser(Request $request, $id) {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        if ($request->input('password'))
            $user->setPassword($request->password);
        $user->setHead($request->input('head'));

        $user->save();

        return Redirect::route('admin.user.index');
    }



    public function test(Request $request) {
        
    }


}
