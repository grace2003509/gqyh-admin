<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Config;
use App\Models\Dis_Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentConfigController extends Controller
{
    /**
     * 分销其他设置展示页面
     */
    public function index()
    {
        $dl_obj = new Dis_Level();
        $dc_obj = new Dis_Config();

        $distribute_level = $dl_obj->get_dis_level();
        //查询最高级别的分销商的信息
        $hige_distribute_level = $distribute_level[max(array_keys($distribute_level))];
        //爵位名称数组
        $dis_title_level = $dc_obj->get_dis_pro_rate_title();
        //获取分销配置信息
        $rsConfig = $dc_obj->find(1);
        $Agent_Rate_list = json_decode($rsConfig['Agent_Rate'],TRUE);
        $Agent_Rate_Commi_list = json_decode($rsConfig['Agent_Rate_Commi'],TRUE);

        return view('admin.distribute.agent_config', compact(
            'distribute_level', 'hige_distribute_level', 'dis_title_level',
            'rsConfig', 'Agent_Rate_Commi_list', 'Agent_Rate_list'));

    }


    /**
     * 保存分销其他设置
     */
    public function update(Request $request)
    {
        $input = $request->input();

        $dc_obj = new Dis_Config();
        $distribute_config = $dc_obj->find(1);

        //分销商代理设置
        $distribute_config->Dis_Agent_Type = $input['Dis_Agent_Type'];
        if($input['Dis_Agent_Type'] == 0){
            $Agent_Rate = '';
            $Agent_Rate_Commi = '';
        }elseif($input['Dis_Agent_Type'] == 1){
            $Agent_Rate = json_encode($input['Agent_Rate'],JSON_UNESCAPED_UNICODE);
            $Agent_Rate_Commi = json_encode($input['Agent_Rate_Commi'],JSON_UNESCAPED_UNICODE);
        }
        $distribute_config->Agent_Rate = $Agent_Rate;
        $distribute_config->Agent_Rate_Commi = $Agent_Rate_Commi;

        $distribute_config->save();

        return redirect()->back()->with('success', '保存成功');
    }
}
