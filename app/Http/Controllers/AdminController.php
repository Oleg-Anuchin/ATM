<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Hash;

class AdminController extends Controller
{
    public function index(Request $request) {
        $users = User::all();
        return view('admin.index')->with('users', $users);
    }

    public function newUser(Request $request) {
        return view('admin.newUser')->with('isEditMode', false);
    }

    public function editUser(Request $request, $id) {
        $user = User::findOrFail($id);
        return view('admin.newUser')
            ->with('isEditMode', true)
            ->with('user', $user);
    }

    public function storeUser(Request $request) {
        $request->merge(['password' => Hash::make($request->password)]);
        $user = User::create($request->all());
        $user->save();

        return Redirect::route('admin.user.index');
    }

    public function updateUser(Request $request, $id) {
        $user = User::findOrFail($id);

        if ($request->input('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        $user = User::create($request->all());
        $user->save();

        return Redirect::route('admin.user.index');

    }


}
