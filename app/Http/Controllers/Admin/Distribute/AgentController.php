<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Area;
use App\Models\Dis_Agent_Area;
use App\Models\Dis_Agent_Record;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentController extends Controller
{
    /**
     * 区域代理人列表
     */
    public function index(Request $request)
    {
        $daa_obj = new Dis_Agent_Area();
        $m_obj = new Member();
        $dar_obj = new Dis_Agent_Record();
        $a_obj = new Area();
        $input = $request->input();

        $Record_Type=array("无","省代","省会","市代","县（区）代");

        //搜索
        if(isset($input["search"]) && $input["search"]==1){
            if(!empty($input["Keyword"])){
                $daa_obj = $daa_obj->where($input["Fields"], 'like', '%'.$input["Keyword"].'%');
            }
            if($input["Status"] != 'all'){
                $daa_obj = $daa_obj->where('type', $input["Status"]);
            }
            if(!empty($input["date-range-picker"])){
                $timer = explode('-', $input["date-range-picker"]);
                $daa_obj = $daa_obj->where('create_at', '>=', strtotime($timer[0]));
                $daa_obj = $daa_obj->where('create_at', '<=', strtotime($timer[1]));
            }
        }

        $agent_list = $daa_obj->orderBy('id', 'desc')->paginate(15);
        foreach($agent_list as $key => $value){

            $value['user'] = $m_obj->select('User_Mobile')->find($value['DisAccount']['User_ID']);
            $money = $dar_obj->where('Account_ID', $value['Account_ID'])->sum('Record_Money');
            $value['money'] = $money['Record_Money'];

            $area = $a_obj->select('area_parent_id', 'area_name')->find($value['area_id']);
            if ($value['type'] == 1) {
                $value['area'] = $value['area_name'];
            }
            if ($value['type'] == 2 || $value['type'] == 3) {
                $pro = $a_obj->select( 'area_name')->find($area['area_parent_id']);
                $value['area'] = $pro['area_name'].'->'.$area['area_name'];
            }
            if ($value['type'] == 4) {
                $city = $a_obj->select('area_parent_id', 'area_name')->find($area['area_parent_id']);
                $pro = $a_obj->select( 'area_name')->find($city['area_parent_id']);
                $value['area'] = $pro['area_name'].'->'.$city['area_name'].'->'.$area['area_name'];
            }

            $value['type'] = $Record_Type[$value['type']];
        }

        return view('admin.distribute.agent', compact('agent_list'));
    }


    /**
     * 区域代理人申请列表
     */
    public function agent_applay()
    {

    }
}
