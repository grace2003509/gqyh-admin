<?php

namespace App\Http\Controllers\Admin\Web;

use App\Models\Setting;
use App\Models\Web_Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LbsController extends Controller
{
    /**
     * 一键导航设置页面
     */
    public function lbs_index()
    {
        $s_obj = new Setting();
        $wc_obj = new Web_Config();

        $setting = $s_obj->select('sys_baidukey')->find(1);
        $ak_baidu = $setting["sys_baidukey"];

        $rsConfig = $wc_obj->find(USERSID);

        return view('admin.web.lbs', compact('ak_baidu', 'rsConfig'));
    }


    /**
     * 保存一键导航设置
     */
    public function lbs_save(Request $request)
    {
        $wc_obj = new Web_Config();
        $input = $request->input();

        $Data=array(
            "Stores_Name"=>$input["StoresName"],
            "Stores_Address"=>$input["Address"],
            "Stores_ImgPath"=>$input["ImgUpload"],
            "Stores_Description"=>$input["StoresDescription"],
            "Stores_PrimaryLng"=>$input["PrimaryLng"],
            "Stores_PrimaryLat"=>$input["PrimaryLat"]
        );
        $Flag = $wc_obj->where('Users_ID', USERSID)->update($Data);

        if($Flag){
            return redirect()->back()->with('success', '保存成功');
        }
    }
}
