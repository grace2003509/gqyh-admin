<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Validator;

class RoleController extends Controller
{
    //展示角色列表
    public function index()
    {
        $roles = Role::all();
        return view('admin.system.role', compact('roles'));
    }

    //创建角色
    public function create()
    {
        return view('admin.system.role_create');
    }

    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
            'name' => 'required|alpha_dash|max:30|unique:roles',
            'description' => 'max:100',
        ];
        $messages = [
            'name.require' => '请输入角色名!!!',
            'name.alpha_dash' => '请正确输入角色名!!!',
            'name.unique' => '角色名已存在!!!',
            'name.max' => '角色名过长!!!',
            'description.max' => '备注过长!!!',
        ];
        $Validator = Validator::make($input, $rules, $messages, [

            'name' => '角色名',

        ]);
        if ($Validator->fails()) {
            return redirect()->route('role.create')
                ->with('errors', $Validator->messages())
                ->with('roledata', $input);
        }
        Role::create($input);
        return redirect()->route('role.index')->with('success', '添加角色成功！');
    }

    public function show()
    {

    }

    //编辑角色
    public function edit($id)
    {
        //判断角色是否为超级管理员
        if (Role::find($id)['name'] == 'administrator') {
            return redirect()->route('role.index')->withErrors('无法对此该角色进行编辑!!!');
        }
        $role = Role::where('id', $id)->get();
        return view('admin.system.role_edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $rules = [
            'name' => 'required|alpha_dash|max:30|unique:roles,name,' . $id . '',
            'description' => 'max:100',
        ];
        $messages = [
            'name.require' => '请输入角色名!!!',
            'name.alpha_dash' => '请正确输入角色名!!!',
            'name.unique' => '角色名已存在!!!',
            'name.max' => '角色名过长!!!',
            'description.max' => '备注过长!!!',
        ];
        $Validator = Validator::make($input, $rules, $messages, [
            'name' => '角色名',
        ]);

        if ($Validator->fails()) {
            return redirect()->route('role.edit', ['id' => $id])
                ->with('errors', $Validator->messages())
                ->with('roledata', $input);
        }
        Role::find($id)->update($input);
        return redirect()->route('role.index')->with('success', '修改角色成功！');

    }


    //删除角色
    public function destroy($id)
    {
        //判断角色是否为超级管理员
        if ($id == 1) {
            return response()->error();
        }
        Role::destroy($id);
        return response()->json(['success']);
    }
}
