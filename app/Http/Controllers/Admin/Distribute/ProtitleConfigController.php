<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProtitleConfigController extends Controller
{
    /**
     * 爵位设置展示页面
     */
    public function index()
    {
        $dc_obj = new Dis_Config();

        $rsConfig = $dc_obj->select('Pro_Title_Level', 'Pro_Title_Status', 'Pro_Title_Rate')->find(1);

        $dis_title_Rate = $rsConfig['Pro_Title_Rate'] ? json_decode($rsConfig['Pro_Title_Rate'],true) : array();
        $dis_level_num = isset($dis_title_Rate['Level_Num']) && $dis_title_Rate['Level_Num'] > 0 ? $dis_title_Rate['Level_Num'] : 1;
        foreach($dis_title_Rate as $k => $v){
            if($k != 'Level_Num' && isset($dis_title_Rate[$k]['check_rate'])){
                $dis_title_Rate[$k]['check_rate'] = explode(',', $dis_title_Rate[$k]['check_rate']);
            }
        }
        return view('admin.distribute.protitle_config', compact('rsConfig', 'dis_title_Rate', 'dis_level_num'));
    }


    /**
     * 保存设置
     */
    public function update(Request $request)
    {
        $input = $request->input();

        $dc_obj = new Dis_Config();
        $distribute_config = $dc_obj->find(1);

        $Dis_List = array();
        $Dis_Pro_Rate =  $input['Dis_Pro_Rate'];

        foreach($Dis_Pro_Rate['Name'] as $key=>$item){
            $Dis_List[$key+1]['Name'] = $item;
            $Dis_List[$key+1]['check_next'] = $Dis_Pro_Rate['check_next'][$key] > 0 ? $Dis_Pro_Rate['check_next'][$key] : 0;
            $Dis_List[$key+1]['check_money'] = $Dis_Pro_Rate['check_money'][$key] > 0 ? $Dis_Pro_Rate['check_money'][$key] : 0;
//        $Dis_List[$key+1]['ImgPath'] = $Dis_Pro_Rate['ImgPath'][$key];
        }
        if(isset($Dis_Pro_Rate['check_rate'])){
            foreach($Dis_Pro_Rate['check_rate'] as $k => $value ){
                $Dis_List[$k]['check_rate'] = implode(',', $value);
            }
        }

        $Dis_List['Level_Num'] = $Dis_Pro_Rate['Level_Num'];
        $distribute_config->Pro_Title_Status = $dc_obj['Pro_Title_Status'];
        $distribute_config->Title_Dislevel = 0;
        $distribute_config->Pro_Title_Rate = json_encode($Dis_List, JSON_UNESCAPED_UNICODE);
        $distribute_config->save();

        return redirect()->route('admin.distribute.protitle_config_index')->with('success', '保存成功');

    }
}
