<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Models\WechatKeyWordReply;
use App\Models\WechatMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KeyWordController extends Controller
{
    public function index()
    {
        $obj = new WechatKeyWordReply();
        $rsReply = $obj->where('Reply_Display', 1)
            ->orderBy('Reply_ID', 'desc')
            ->paginate(15);
        foreach($rsReply as $key => $value){
            $Reply_Keywords = explode("\n", $value["Reply_Keywords"]);
            $Keywords = "";
            foreach ($Reply_Keywords as $v) {
                $value['Keywords'] .= '【' . $v . '】';
            }
        }
        return view('admin.wechat.key_word', compact('rsReply', 'Keywords'));
    }

    public function add()
    {
        $wm_obj = new WechatMaterial();
        $sys_material = $wm_obj->get_sys_material(1);//系统图文
        $diy_material = $wm_obj->get_sys_material(0);//自定义图文
        return view('admin.wechat.key_word_add', compact('sys_material', 'diy_material'));
    }

    public function store(Request $request)
    {
        $input = $request->input();

        $rules = [
            'Keywords' => 'required'
        ];
        $messages = [
            'Keywords.required' => '关键词不能为空'
        ];
        $validator = Validator::make($input, $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages());
        }

        $Data=array(
            "Reply_Table"=>0,
            "Reply_TableID"=>0,
            "Reply_Display"=>1,
            "Reply_Keywords"=>$input["Keywords"],
            "Reply_PatternMethod"=>empty($input["PatternMethod"])?0:$input["PatternMethod"],
            "Reply_MsgType"=>$input["ReplyMsgType"],
            "Reply_TextContents"=>isset($input['TextContents'])?$input['TextContents']:"",
            "Reply_MaterialID"=>empty($input['MaterialID'])?0:$input['MaterialID'],
            "Users_ID"=>USERSID
        );
        $obj = new WechatKeyWordReply();
        $Flag=$obj->create($Data);
        if($Flag){
            return redirect()->route('admin.wechat.keyword_index')->with('success', '添加成功');
        }else{
            return redirect()->back()->with('errors', '添加失败');
        }
    }

    public function edit($id)
    {
        $key_obj = new WechatKeyWordReply();
        $rsReply = $key_obj->find($id);

        $wm_obj = new WechatMaterial();
        $sys_material = $wm_obj->get_sys_material(1);//系统图文
        $diy_material = $wm_obj->get_sys_material(0);//自定义图文
        return view('admin.wechat.key_word_edit',
            compact('rsReply', 'sys_material', 'diy_material'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->input();

        $rules = [
            'Keywords' => 'required'
        ];
        $messages = [
            'Keywords.required' => '关键词不能为空'
        ];
        $validator = Validator::make($input, $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages());
        }

        $Data=array(
            "Reply_Table"=>0,
            "Reply_TableID"=>0,
            "Reply_Display"=>1,
            "Reply_Keywords"=>$input["Keywords"],
            "Reply_PatternMethod"=>empty($input["PatternMethod"])?0:$input["PatternMethod"],
            "Reply_MsgType"=>$input["ReplyMsgType"],
            "Reply_TextContents"=>isset($input['TextContents'])?$input['TextContents']:"",
            "Reply_MaterialID"=>empty($input['MaterialID'])?0:$input['MaterialID'],
            "Users_ID"=>USERSID
        );
        $obj = new WechatKeyWordReply();
        $rst = $obj->find($id);
        $Flag=$rst->update($Data);
        if($Flag){
            return redirect()->route('admin.wechat.keyword_index')->with('success', '保存成功');
        }else{
            return redirect()->back()->with('errors', '保存失败');
        }
    }

    public function del($id)
    {
        $obj = new WechatKeyWordReply();
        $Flag = $obj->destroy($id);
        if($Flag){
            return redirect()->route('admin.wechat.keyword_index')->with('success', '删除成功');
        }else{
            return redirect()->back()->with('errors', '删除失败');
        }
    }
}
