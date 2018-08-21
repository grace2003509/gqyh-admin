<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Models\ReplyConfig;
use App\Models\WechatMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplyConfigController extends Controller
{
    public function index()
    {
        $reply_obj = new ReplyConfig();
        $rsReply = $reply_obj->find(1);

        $m_obj = new WechatMaterial();
        $sys_material = $m_obj->get_sys_material(1);//系统图文
        $diy_material = $m_obj->get_sys_material(0);//自定义图文

        return view('admin.wechat.reply_config', compact('rsReply', 'sys_material', 'diy_material'));
    }


    public function edit(Request $request)
    {
        $input = $request->input();

        $reply_obj = new ReplyConfig();
        $rsReply = $reply_obj->find(1);
        if($rsReply)
        {
            $Data=array(
                "Reply_MsgType"=>$input["ReplyMsgType"],
                "Reply_TextContents"=>isset($input["ReplyTextContents"])?$input["ReplyTextContents"]:"",
                "Reply_MaterialID"=>empty($input["ReplyMaterialID"])?0:$input["ReplyMaterialID"],
                "Reply_Subscribe"=>isset($input["ReplySubscribe"])?1:0,
                "Reply_MemberNotice"=>isset($input["MemberNotice"])?1:0
            );

            $Flag = $rsReply->update($Data);
        }else
        {
            $Data=array(
                "Reply_MsgType"=>$_POST["ReplyMsgType"],
                "Reply_TextContents"=>isset($_POST["ReplyTextContents"])?$_POST["ReplyTextContents"]:"",
                "Reply_MaterialID"=>empty($_POST["ReplyMaterialID"])?0:$_POST["ReplyMaterialID"],
                "Reply_Subscribe"=>isset($_POST["ReplySubscribe"])?1:0,
                "Users_ID"=>$_SESSION["Users_ID"],
                "Reply_MemberNotice"=>isset($_POST["MemberNotice"])?1:0

            );

            $Flag=$reply_obj->create($Data);
        }
        if($Flag)
        {
            return redirect()->route('admin.wechat.reply_index')->with('success', '保存成功');
        }else
        {
            return redirect()->route('admin.wechat.reply_index')->with('errors', '保存失败');
        }

    }
}
