<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Models\Member;
use App\Models\User;
use App\Models\UsersConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiConfigController extends Controller
{
    public function index()
    {
        $rsUsers=UsersConfig::first();

        $host = $_SERVER["HTTP_HOST"];

        return view('admin.wechat.api_config', compact('rsUsers', 'host'));
    }

    public function edit(Request $request)
    {
        $input = $request->input();
        //有上传文件时
        $save_path = $_SERVER['DOCUMENT_ROOT'];
        $max_size = 1024 * 512;
        $ext_arr = ['txt'];
        $file_name = '';

        $erroro = $_FILES['imgFile']['error'];
        if (($erroro)!='4') {
            //原文件名
            $file_name = $_FILES['imgFile']['name'];
            //服务器上临时文件名
            $tmp_name = $_FILES['imgFile']['tmp_name'];
            //文件大小
            $file_size = $_FILES['imgFile']['size'];
            //检查文件名
            if (!$file_name) {
                alert("请选择文件。");
            }

            //检查文件名是否符合要求
            $ask = 'MP_verify_';
            if(strstr($file_name,$ask) === false){
                alert("不是微信认证文件，请重新上传");
            }

            //检查目录
            if (@is_dir($save_path) === false) {
                alert("上传目录不存在。");
            }
            //检查目录写权限
            if (@is_writable($save_path) === false) {
                alert("上传目录没有写权限。");
            }
            //检查是否已上传
            if (@is_uploaded_file($tmp_name) === false) {
                alert("上传失败。");
            }
            //检查文件大小
            if ($file_size > $max_size) {
                alert("上传文件大小超过".($max_size/1024)."K限制。");
            }

            //获得文件扩展名
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);

            //检查扩展名
            if (in_array($file_ext, $ext_arr) === false) {

                alert("上传文件只允许TXT格式。");
            }

            $file_path = $save_path . '/' . $file_name;

            if (move_uploaded_file($tmp_name, $file_path) === false) {
                alert("上传文件失败。");
            }

        }
        $rsUsers=UsersConfig::find(USERSID);
        if (($erroro)=='4') {
            $file_name = $rsUsers['weixinfile'];
        }

        $Data=array(
            "Users_WechatName"=>trim($input["WechatName"]),
            "Users_WechatEmail"=>trim($input["WechatEmail"]),
            "Users_WechatID"=>trim($input["WechatID"]),
            "Users_WechatAccount"=>trim($input["WechatAccount"]),
            "Users_EncodingAESKey"=>trim($input["EncodingAESKey"]),
            "Users_EncodingAESKeyType"=>$input["EncodingAESKeyType"],
            "Users_WechatAppId"=>trim($input["WechatAppId"]),
            "Users_WechatAppSecret"=>trim($input["WechatAppSecret"]),
            "Users_WechatAuth"=>isset($input["WechatAuth"])?1:0,
            "Users_WechatVoice"=>isset($input["WechatVoice"])?1:0,
            "Users_WechatType"=>$input["WechatType"],
            "weixinfile"=> $file_name
        );
        $Flag=$rsUsers->update($Data);
        if($Flag){
            return redirect()->route('admin.wechat.api_index')->with('success','保存成功');
        }else{
            return redirect()->route('admin.wechat.api_index')->with('errors','保存失败');
        }
    }
}
