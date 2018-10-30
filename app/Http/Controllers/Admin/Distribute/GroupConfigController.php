<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupConfigController extends Controller
{
    //分销首页设置展示页面
    public function index()
    {
        $dc_obj = new Dis_Config();

        $rsAccount = $dc_obj->select('Dis_Mobile_Level', 'Index_Professional_Json')->find(1);
        if (!empty($rsAccount['Index_Professional_Json'])){
            $Index_Professional_Json = json_decode($rsAccount['Index_Professional_Json'], TRUE);
        } else {
            $Index_Professional_Json = array(
                'myterm' => '我的团队',
                'childlevelterm' => config('level.dis_level'),
                'catcommission' => '佣金',
                'cattuijian' => '我的推荐人',
                'childtuijian' => config('level.dis_recommend')
            );
        }
        $level_name_list = config('level.dis_level');

        return view('admin.distribute.group_config', compact(
            'rsAccount', 'Index_Professional_Json', 'level_name_list'));

    }


    /**
     * 保存设置
     */
    public function update(Request $request)
    {
        $input = $request->input();

        $dc_obj = new Dis_Config();

        $data = [
            'myterm'=>$input['my_term'],
            'childlevelterm'=>$input['child_level_term'],
            'catcommission' => $input['catcommission'],
            'cattuijian' => $input['cattuijian']
        ];
        $s = json_encode($data, JSON_UNESCAPED_UNICODE);

        $dc_obj->where('id', 1)->update(['Index_Professional_Json' => $s]);

        return redirect()->route('admin.distribute.group_config_index')->with('success', '设置成功');
    }
}
