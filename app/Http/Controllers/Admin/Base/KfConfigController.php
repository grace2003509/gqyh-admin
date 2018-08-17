<?php

namespace App\Http\Controllers\Admin\Base;

use App\Models\Kf_Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KfConfigController extends Controller
{
    public function index()
    {

        $rsConfig = Kf_Config::first();
        if (empty($rsConfig)) {
            $Data = array(
                "KF_Icon" => '/admin/images/kf/ico/00.png'
            );
            Kf_Config::create($Data);
            $rsConfig = Kf_Config::first();
        }
        return view('admin.base.kf_config', compact('rsConfig'));
    }



    public function edit(Request $request)
    {
        $data = $request->input();

        if($data["kftype"] == 1){
            $QQ_DATA = [
                'KF_Code' => $data['Code'],
                'kftype' => $data['kftype'],
                'qq_postion' => $data['qq_postion'],
                'qq_icon' => $data['qq_icon'],
                'qq' => trim($data['qq']),
                'KF_IsWeb' => isset($data['KF_IsWeb']) ? $data['KF_IsWeb']: 0,
                'KF_IsShop' => isset($data['KF_IsShop']) ? $data['KF_IsShop']: 0,
                'KF_IsUser' => isset($data['KF_IsUser']) ? $data['KF_IsUser']: 0,
                'KF_kanjia' => isset($data['KF_kanjia']) ? $data['KF_kanjia']: 0,
            ];
            $Flag = Kf_Config::where('KF_ID', 1)->update($QQ_DATA);

        }else{
            $THIRD_DATA = [
                'KF_Code' => $data['Code'],
                'kftype' => $data['kftype'],
                'KF_Link' => $data['CodeLink'],
                'KF_IsWeb' => isset($data['KF_IsWeb']) ? $data['KF_IsWeb']: 0,
                'KF_IsShop' => isset($data['KF_IsShop']) ? $data['KF_IsShop']: 0,
                'KF_IsUser' => isset($data['KF_IsUser']) ? $data['KF_IsUser']: 0,
                'KF_kanjia' => isset($data['KF_kanjia']) ? $data['KF_kanjia']: 0,
            ];
            $Flag = Kf_Config::where('KF_ID', 1)->update($THIRD_DATA);
        }

        if($Flag){
            return redirect()->route('admin.base.kf_index')->with('success', '设置成功！');
        }else{
            return redirect()->route('admin.base.kf_index')->with('errors', '设置失败！');
        }

    }

}
