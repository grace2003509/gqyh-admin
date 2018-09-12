<?php

namespace App\Http\Controllers\Admin\Member;

use App\Models\User_Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $um_obj = new User_Message();
        $messages = $um_obj->where('User_ID', 0)
            ->orderBy('Message_ID', 'desc')
            ->paginate(15);

        return view('admin.member.message', compact('messages'));

    }


    public function create()
    {
        return view('admin.member.message_create');
    }


    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
            'Title' => 'required|string|max:50',
        ];
        $message = [
            'Title.required' => '标题不能为空',
            'Title.max' => '标题过长'
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $Data=array(
            "Message_Title"=>$input['Title'],
            "Message_Description"=>$input['Description'],
            "Message_CreateTime"=>time(),
            "Users_ID"=>USERSID
        );
        $um_obj = new User_Message();
        $Flag=$um_obj->create($Data);

        if($Flag){
            return redirect()->route('admin.member.message_index')->with('success', '发布成功');
        }else{
            return redirect()->back()->with('errors', '发布失败')->withInput();
        }
    }


    public function edit($id)
    {
        $um_obj = new User_Message();
        $message = $um_obj->find($id);
        return view('admin.member.message_edit', compact('message'));
    }


    public function update(Request $request, $id)
    {
        $input = $request->input();
        $rules = [
            'Title' => 'required|string|max:50',
        ];
        $message = [
            'Title.required' => '标题不能为空',
            'Title.max' => '标题过长'
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $um_obj = new User_Message();
        $message = $um_obj->find($id);
        $Data=array(
            "Message_Title"=>$input['Title'],
            "Message_Description"=>$input['Description'],
        );
        $Flag=$message->update($Data);

        if($Flag){
            return redirect()->route('admin.member.message_index')->with('success', '编辑成功');
        }else{
            return redirect()->back()->with('errors', '编辑失败')->withInput();
        }
    }


    public function del($id)
    {
        $um_obj = new User_Message();
        $flag = $um_obj->destroy($id);
        if($flag){
            return redirect()->back()->with('success', '删除成功');
        }else{
            return redirect()->back()->with('errors', '删除失败');
        }
    }


}
