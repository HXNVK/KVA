<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Hash;
use Log;

class UserController extends Controller
{
    public function index() {
        $users = User::orderBy('name')
        ->get();
        
        return view('users.index')
            ->with('users', $users);
    }

    public function create() {
        $user = new User();
        $roles = Role::pluck('name','name')->all();
        $userRole = [];

        return view('users.create')
            ->with('user', $user)
            ->with('roles', $roles)
            ->with('userRole', $userRole)
            ;
    }

    public function store(Request $request) {
        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
            ]
        );

        $user = User::create($request->all() + ['password' => Hash::make($request->get('new_password'))]);
        $user->syncRoles($request->get('roles'));

        return redirect()->route('users.index')->with('message', 'User created');
    }

    public function edit($id) {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('users.edit')
            ->with('user', $user)
            ->with('roles', $roles)
            ->with('userRole', $userRole)
            ;
    }
    public function update(Request $request, $id) {
        $user = User::find($id);

        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
            ]
        );

        $user->update($request->all());
        if($request->get('new_password')) {
            $user->password = Hash::make($request['new_password']);
        }
        $user->save();

        $user->syncRoles($request->get('roles'));

        return redirect()->route('users.index')->with('message', 'User updated');
    }
}
