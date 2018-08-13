<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //展示用户列表
    public function index()
    {

        $users = User::paginate(20);

        $user_role = [];

        foreach ($users as $user) {
            $user_role[$user->id] = implode('，', $user->roles->map(function ($role) {
                return $role->name;
            })->toArray());
        }
        return view('admin.system.user', compact('users', 'user_role'));
    }


    //新建用户
    public function create()
    {
        return view('admin.system.user_create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $rules = [
            'name' => 'alpha_dash|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:60',
            'password_confirm' => 'required|same:password',
        ];

        $messages = [
            'name.alpha_dash' => '用户名由中文、数字、字母、下划线组成!!!',
            'name.max' => '用户名过长!!!',
            'name.unique:users' => '用户名已存在!!!',
            'email.required' => '请输入邮箱!!!',
            'email.email' => '请输入正确的邮件格式!!!',
            'email.unique:users' => '邮箱已存在!!!',
            'password.required' => '请输入密码!!!',
            'password.min' => '密码少于6位!!!',
            'password.max' => '密码过长!!!',
            'password_confirm.required' => '请再次输入密码!!!',
            'password_confirm.same' => '两次密码输入不一致!!!',
        ];

        $validator = Validator::make($input, $rules, $messages, [
            'name' => '用户名',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.create')
                ->with('errors', $validator->messages())
                ->with('userdata', $input);
        }

        $input['password'] = bcrypt($input['password']);
        User::create($input);
        return redirect()->route('user.index')->with('success', '添加用户成功！');

    }


    public function show($id)
    {

    }


    //编辑用户
    public function edit(Request $request, $id)
    {
        $user = $request->user()->where('id', $id)->get();
        return view('admin.system.user_edit', compact('user'));

    }

    public function update(Request $request, $id)
    {

        $input = $request->all();

        $rules = [
            'name' => 'required|alpha_dash|max:20|unique:users,name,' . $id . '',
            'email' => 'required|email|unique:users,email,' . $id . '',
            'password' => 'required|min:6|max:60',
            'password_confirm' => 'required|same:password',
        ];

        $messages = [
            'name.alpha_dash' => '用户名由中文、数字、字母、下划线组成!!!',
            'name.max' => '用户名过长!!!',
            'name.unique:users' => '用户名已存在!!!',
            'email.required' => '请输入邮箱!!!',
            'email.email' => '请输入正确的邮件格式!!!',
            'email.unique:users' => '邮箱已存在!!!',
            'password.required' => '请输入密码!!!',
            'password.min' => '密码少于6位!!!',
            'password.max' => '密码过长!!!',
            'password_confirm.required' => '请再次输入密码!!!',
            'password_confirm.same' => '两次密码输入不一致!!!',
        ];

        $validator = Validator::make($input, $rules, $messages, [
            'name' => '用户名',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.edit', ['id' => $id])
                ->with('errors', $validator->messages())
                ->with('userdata', $input);
        }

        //原密码
        $res = $request->user()->where('id', $id)->select('password')->first();

        //判断是否修改了密码
        if ($input['password'] == $res->password) {
            $input = array_except($input, 'password');
        } else {
            $input['password'] = bcrypt($input['password']);
        }

        $request->user()->find($id)->update($input);
        return redirect()->route('user.index')->with('success', '修改用户成功！');
    }


    //删除用户
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $role = Role::where('id', 1)->first();
        if (($id == Auth::user()->id) || ($user->hasRole($role['name']))) {
            return response()->error();
        }
        User::destroy($id);
        return response()->json(['success']);
    }
}
