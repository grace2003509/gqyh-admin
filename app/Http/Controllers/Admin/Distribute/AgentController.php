<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Agent_Order;
use App\Models\Area;
use App\Models\Dis_Agent_Area;
use App\Models\Dis_Agent_Record;
use App\Models\Member;
use App\Models\UserOrder;
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
    public function agent_apply(Request $request)
    {
        $ao_obj = new Agent_Order();
        $input = $request->input();

        $Order_Status=array("待审核","待付款","已付款",'已取消','已拒绝');

        //搜索
        if(isset($input["search"]) && $input["search"]==1){
            if(!empty($input["Keyword"])){
                $ao_obj = $ao_obj->where($input["Fields"], 'like', '%'.$input["Keyword"].'%');
            }
            if(!empty($input["OrderNo"])){
                $OrderID = substr($input["OrderNo"],8);
                $OrderID =  empty($OrderID) ? 0 : intval($OrderID);
                $ao_obj = $ao_obj->where('Order_ID', $OrderID);
            }
            if($input["Status"] != 'all'){
                $ao_obj = $ao_obj->where('Order_Status', $input["Status"]);
            }
            if(!empty($input["date-range-picker"])){
                $timer = explode('-', $input["date-range-picker"]);
                $ao_obj = $ao_obj->where('Order_CreateTime', '>=', strtotime($timer[0]));
                $ao_obj = $ao_obj->where('Order_CreateTime', '<=', strtotime($timer[1]));
            }
        }

        $agent_order_list = $ao_obj->orderBy('Order_ID', 'desc')->paginate(15);
        foreach($agent_order_list as $key => $value){
            $value['order_no'] = date("Ymd",$value["Order_CreateTime"]).$value["Order_ID"];
            $value['status'] = $Order_Status[$value['Order_Status']];
        }

        return view('admin.distribute.agent_apply', compact('agent_order_list'));
    }


    /**
     * 区域代理申请详情
     */
    public function agent_apply_view($id)
    {
        $ao_obj = new Agent_Order();

        $Order_Status = array("待审核","待付款","已付款",'已取消','已拒绝');

        $rsOrder = $ao_obj->find($id);
        $rsOrder["order_no"] = date("Ymd",$rsOrder["Order_CreateTime"]).$rsOrder["Order_ID"];
        $rsOrder["status"] = $Order_Status[$rsOrder['Order_Status']];
        if(empty($rsOrder["Order_PaymentMethod"]) || $rsOrder["Order_PaymentMethod"]=="0"){
            $rsOrder["Order_PaymentMethod"] = "暂无";
        }

        return view('admin.distribute.agent_apply_view', compact('rsOrder'));

    }


    /**
     * 区域代理审核
     * @param Request $request
     * @param $id
     */
    public function agent_apply_audit(Request $request, $id)
    {
        $input = $request->input();
        $ao_obj = new Agent_Order();

        if($input["refuse"] == 1){
            $Data=array(
                "Order_Status"=>1
            );
        }else{
            $Data=array(
                "Order_Status"=>4,
                "Refuse_Be"=>$input["refusebe"]
            );
        }

        $Flag=$ao_obj->where('Order_ID', $id)->update($Data);

        if($Flag){
            if($input["refuse"] == 1){
                return redirect()->route('admin.distribute.agent_apply')->with('success', '申请已通过');
            }else{
                return redirect()->route('admin.distribute.agent_apply')->with('success', '申请已回绝');
            }
        }else{
            return redirect()->back()->with('errors', '审核出错');
        }

    }


}
