<?php

namespace App\Http\Controllers\Admin\Base;

use App\Models\Setting;
use App\Models\UploadFile;
use App\Services\ImageThum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SysConfigController extends Controller
{
    public function index()
    {
        $setting = Setting::find(1);
        return view('admin.base.sys_config', compact('setting'));
    }


    public function edit(Request $request)
    {
        $data = $request->input();
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name.required' => '系统名称不能为空!!!'
        ];
        $Validator = Validator::make($data, $rules, $messages, [
            'name' => '系统名称',
        ]);
        if ($Validator->fails()) {
            return redirect()->route('admin.base.sys_index')->with('errors', $Validator->messages());
        }

        $data['copyright'] = str_replace('"','&quot;',$data['copyright']);
        $data['copyright'] = str_replace("'","&quot;",$data['copyright']);
        $name = trim($data["name"]);

        $set = Setting::find(1);
        $set_data=array(
            "sys_name"=>$name,
            "sys_dommain"=>$data["dommain"],
            "sys_copyright"=>$data["copyright"],
            "sys_logo"=>$data["Img"],
            "sys_baidukey"=>$data["baidukey"]
        );
        $Flag = $set->update($set_data);
        if($Flag){
            return redirect()->route('admin.base.sys_index')->with('success', '设置成功！');
        }else{
            return redirect()->route('admin.base.sys_index')->with('errors', '设置失败！');
        }
    }

}
