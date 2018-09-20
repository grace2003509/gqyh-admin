<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Account;
use App\Models\Dis_Account_Record;
use App\Models\Dis_Config;
use App\Models\Dis_Level;
use App\Models\Dis_Point_Record;
use App\Models\Member;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisAccountController extends Controller
{
    /**
     * 分销账号列表页
     */
    public function index(Request $request)
    {
        $dc_obj = new Dis_Config();
        $dl_obj = new Dis_Level();
        $da_obj = new Dis_Account();
        $uo_obj = new UserOrder();
        $dar_obj = new Dis_Account_Record();
        $m_obj = new Member();
        $dpr_obj = new Dis_Point_Record();

        $rsConfig = $dc_obj->find(1);

        $dis_title_level = $dc_obj->get_dis_pro_rate_title();

        $dis_title_level = !$dis_title_level ? [] : $dis_title_level;
        $rsDis_Level = $dl_obj->select('Level_ID','Level_Name')->get();

        //搜索
        $input = $request->input();
        if(isset($input["search"]) && $input["search"] == 1){

            if(!empty($input["Keyword"])&&strlen(trim($input["Keyword"]))>0){
                $a_user = $m_obj->select('User_ID')
                    ->where('User_Mobile','like','%'. $input['Keyword'].'%')
                    ->get();
                $aids = [];
                foreach($a_user as $k => $v){
                    $aids[] = $v['User_ID'];
                }
                $da_obj = $da_obj->whereIn("invite_id",$aids);
            }
            if(!empty($input["Mobile"])&& strlen(trim($input["Mobile"]))>0){
                $a_user = $m_obj->select('User_ID')
                    ->where('User_Mobile','like','%'. $input['Mobile'].'%')
                    ->get();
                $aids = [];
                foreach($a_user as $k => $v){
                    $aids[] = $v['User_ID'];
                }
                $da_obj = $da_obj->whereIn("User_ID",$aids);
            }
            if($input['level'] != 'all'){
                $da_obj = $da_obj->where('Professional_Title',$input['level']);
            }
            if(!empty($input['dis_level'])){
                $da_obj = $da_obj->where('Level_ID',$input['dis_level']);
            }

        }

        $account_list = $da_obj->orderBy('Account_CreateTime', 'desc')->paginate(15);
        foreach($account_list as $key => $account){
            $account['Total_Sales'] = $uo_obj->where(['Owner_ID'=>$account['User_ID'],'Order_Status'=>4])
                ->sum('Order_TotalPrice');

            $level_name = $dl_obj->select('Level_Name')->where('Level_ID', $account['Level_ID'])->first();
            $account['Level_Name'] = $level_name['Level_Name'];

            $account['Total_Income'] = $dar_obj->get_my_leiji_income($account['User_ID']);//累计佣金

            if($account['invite_id'] == 0){
                $account['inviter_name'] = '顶级';
            }else{
                $upuser = $m_obj->select('User_Mobile')->find($account['invite_id']);
                $account['inviter_name'] =  !empty($upuser) ? $upuser['User_Mobile'] : '信息缺失';
            }

            $account['nobi_Total'] = $dpr_obj->where(['User_ID'=> $account['User_ID'], 'type' => 4])->sum('money');

            //团队销售额
            $da_obj1 = new Dis_Account();
            $posterity = $da_obj1->getPosterity();
            $account['Sales_Group'] = $uo_obj->get_my_leiji_vip_sales($account['User_ID'],$posterity, 0, 1);
        }

        $base_url = 'http://'.$_SERVER['HTTP_HOST'].'/';

        return view('admin.distribute.account', compact(
            'dis_title_level', 'rsDis_Level', 'account_list', 'rsConfig', 'base_url'));

    }

    /**
     * 修改分销账号状态
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * 删除分销账号
     */
    public function del($id)
    {

    }


    /**
     * 获得代理区域信息
     */
    public function get_agent_info(Request $request)
    {

    }
}
