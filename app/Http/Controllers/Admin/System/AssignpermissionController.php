<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Controllers\Controller;

class AssignpermissionController extends Controller
{
    public function edit($id)
    {
        $role = Role::find($id);
        $role_name = $role['name'];

        //判断角色是否为超级管理员
        if ($role_name == 'administrator') {
            return redirect()->route('role.index')->withErrors('无法对该角色分配权限!!!');
        }

        $permissions = Permission::all();
        $role_permission = [];

        //判断角色有哪些权限
        foreach ($permissions as $permission) {
            $role_permission[$permission->name] = $role->hasPermission($permission->name);
        }
        return view('admin.system.assign_permission', compact('id', 'role_name', 'role_permission'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $permission_names = $request->input('permission_names');

        //解绑原有权限
        if (count($role->perms)) {
            $role->detachPermissions($role->perms);
        }
        $role->save();
        if (!count($permission_names)) {
            return redirect()->route('role.index')->with('success', '权限分配成功！');
        }
        foreach ($permission_names as $names) {
            $permission_ids[] = Permission::where('name', $names)->value('id');
        }

        //赋予改变后权限
        $role->attachPermissions($permission_ids);
        return redirect()->route('role.index')->with('success', '权限分配成功！');
    }
}
