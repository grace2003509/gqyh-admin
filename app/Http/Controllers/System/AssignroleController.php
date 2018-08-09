<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;

class AssignroleController extends Controller
{
    public function edit($id)
    {
        $user = User::find($id);
        $user_name = $user['name'];
        $roles = Role::all();
        $user_role = [];

        //判断该用户的角色
        foreach ($roles as $role) {
            $user_role[$role->name] = $user->hasRole($role->name);
        }
        return view('system.assign_role', compact('id', 'user_name', 'roles', 'user_role'));
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $role_ids = $request->input('role');

        //解绑原有角色
        if (count($user->roles)) {
            $user->detachRoles($user->roles);
        }
        $user->save();

        if (!count($role_ids)) {
            return redirect()->route('user.index')->with('success', '角色分配成功！');
        }

        //赋予改变后角色
        $user->attachRoles($role_ids);
        return redirect()->route('user.index')->with('success', '角色分配成功！');
    }
}
