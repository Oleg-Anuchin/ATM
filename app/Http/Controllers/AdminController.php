<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Hash;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request) {
        $this->authorize('useAdmin', Auth::user());

        $users = User::all();
        return view('admin.index')
            ->with('users', $users)
            ->with('staffTree', User::get()->toTree());
    }

    public function newUser(Request $request) {
        $this->authorize('useAdmin', Auth::user());

        $heads = User::getHeads(null);
        return view('admin.newUser')
            ->with('heads', $heads)
            ->with('isEditMode', false)
            ->with('roles', User::getRoles());
        
    }

    public function editUser(Request $request, $id) {
        $this->authorize('useAdmin', Auth::user());

        $user = User::findOrFail($id);
        $currentHeadId = $user->getCurrentHeadId();
        $heads = $user->getHeads($user);
        return view('admin.newUser')
            ->with('isEditMode', true)
            ->with('user', $user)
            ->with('heads', $heads)
            ->with('currentHeadId', $currentHeadId)
            ->with('roles', User::getRoles());
    }

    public function storeUser(Request $request) {
        $this->authorize('useAdmin', Auth::user());

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->setPassword($request->password);
        $user->setHead($request->input('head'));
        $user->setRole($request->input('role'));
        $user->save();


        return Redirect::route('admin.user.index');
    }

    public function updateUser(Request $request, $id) {
        $this->authorize('useAdmin', Auth::user());
        
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        if ($request->input('password'))
            $user->setPassword($request->password);
        $user->setHead($request->input('head'));
        $user->setRole($request->input('role'));
        $user->save();
        $user->hasMoved();

        return Redirect::route('admin.user.index');
    }



    public function test(Request $request) {
        
    }


}
