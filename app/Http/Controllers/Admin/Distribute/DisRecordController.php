<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Account_Record;
use App\Models\Dis_Agent_Record;
use App\Models\Dis_Point_Record;
use App\Models\Member;
use App\Models\ShopProduct;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisRecordController extends Controller
{
    /**
     * 分销佣金记录
     */
    public function account_record(Request $request)
    {
        $dar_obj = new Dis_Account_Record();
        $sp_obj = new ShopProduct();
        $uo_obj = new UserOrder();
        $m_obj = new Member();
        $input = $request->input();

        $record_status = array('已生成', '已付款', '已完成');
        $level_name = config('level.level_name_record');
        $user_id_array = [];

        //搜索
        if (isset($input["search"]) && $input["search"] == 1) {
            if ($input["Status"] != 'all') {
                $dar_obj = $dar_obj->where('Record_Status', $input["Status"]);
            }
            if (!empty($input["date-range-picker"])) {
                $timer = explode('-', $input['date-range-picker']);
                $dar_obj = $dar_obj->where('Record_CreateTime', '>=', strtotime($timer[0]));
                $dar_obj = $dar_obj->where('Record_CreateTime', '<=', strtotime($timer[1]));
            }
        }

        $record_list = $dar_obj->orderBy('Record_ID', 'desc')
            ->paginate(15);
        foreach ($record_list as $key => $value) {
            $user_id_array[] = $value['DisRecord']['Buyer_ID'];
            $user_id_array[] = $value['DisRecord']['Owner_ID'];
            $product = $sp_obj->select('Products_Name')
                ->where('Products_ID', $value['DisRecord']['Product_ID'])
                ->first();
            $value['Product_Name'] = $product['Products_Name'] ? $product['Products_Name'] : '产品已删';

            $value['status'] = $record_status[$value['Record_Status']];
            $value['order_no'] = $uo_obj->getorderno($value['DisRecord']['Order_ID']);
            $buy_user = $m_obj->select('User_Mobile')->find($value['DisRecord']['Buyer_ID']);
            $value['buyer'] = $buy_user['User_Mobile'] ? $buy_user['User_Mobile'] : '';


            if (isset($level_name[$value['level']]) || $value['level'] == 110) {
                $user_owner = $m_obj->select('User_Mobile')->find($value['User_ID']);
                $value['money_des'] = !empty($user_owner['User_Mobile']) ? $user_owner['User_Mobile'] : '无昵称' . '&nbsp;&nbsp;';

                if ($value['DisRecord']['Buyer_ID'] == $value['User_ID']) {
                    $value['money_des'] .= '自销获';
                } else {
                    if ($value['Record_Money'] > 0) {
                        $value['money_des'] .= '获' . $level_name[$value['level']];
                    }
                }

                if ($value['Record_Money'] >= 0) {
                    $value['money_des'] .= '奖金￥' . round_pad_zero($value['Record_Money'], 2) . '('.$value['Record_Description'].')';
                } else {
                    $value['money_des'] .= '用户退款,金额￥' . $value['Record_Money'];
                }

            } else {
                $value['money_des'] .= !empty($user_owner['User_Mobile']) ? $user_owner['User_Mobile'] : '无昵称' . '&nbsp;&nbsp;';
            }


            $user_id_array[] = $value['User_ID'];
        }

        $user_id_array = array_unique($user_id_array);
        $user_id_array = array_filter($user_id_array);

        if (!empty($user_id_array)) {
            $user_dictionary = $m_obj->whereIn('User_ID', $user_id_array)
                ->get()->getDictionary();
            if (!empty($user_dictionary)) {
                foreach ($user_dictionary as $User_ID => $User) {
                    $user_dropdown[$User->User_ID] = $User->User_Mobile;
                }
            }
        }

        return view('admin.distribute.account_record', compact('record_list'));
    }


    /**
     * 重消奖记录
     */
    public function point_record(Request $request)
    {
        $dpr_obj = new Dis_Point_Record();
        $input = $request->input();

        if (isset($input["search"]) && $input["search"] == 1) {
            if (!empty($input["date-range-picker"])) {
                $timer = explode('-', $input['date-range-picker']);
                $dpr_obj = $dpr_obj->where('created_at', '>=', strtotime($timer[0]));
                $dpr_obj = $dpr_obj->where('created_at', '<=', strtotime($timer[1]));
            }
        }

        $Order_Status = array("待付款", "已付款", "已完成");

        $rsRecordList = $dpr_obj->where('type', 2)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        foreach ($rsRecordList as $key => $value) {
            $value['status'] = $Order_Status[$value['status']];
        }
        return view('admin.distribute.point_record', compact('rsRecordList'));
    }



    /**
     * 团队奖记录
     */
    public function protitle_record(Request $request)
    {
        $dpr_obj = new Dis_Point_Record();
        $input = $request->input();

        if (isset($input["search"]) && $input["search"] == 1) {
            if (!empty($input["date-range-picker"])) {
                $timer = explode('-', $input['date-range-picker']);
                $dpr_obj = $dpr_obj->where('created_at', '>=', strtotime($timer[0]));
                $dpr_obj = $dpr_obj->where('created_at', '<=', strtotime($timer[1]));
            }
        }

        $rsRecordList = $dpr_obj->where('type', 4)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        foreach ($rsRecordList as $key => $value) {
            $value['status'] = $value['status'] == 2 ? '已完成' : '未完成';
        }
        return view('admin.distribute.point_record', compact('rsRecordList'));
    }


    /**
     * 区域代理奖记录
     */
    public function agent_record(Request $request)
    {
        $dpr_obj = new Dis_Point_Record();
        $input = $request->input();

        if (isset($input["search"]) && $input["search"] == 1) {
            if (!empty($input["date-range-picker"])) {
                $timer = explode('-', $input['date-range-picker']);
                $dpr_obj = $dpr_obj->where('created_at', '>=', strtotime($timer[0]));
                $dpr_obj = $dpr_obj->where('created_at', '<=', strtotime($timer[1]));
            }
        }

        $rsRecordList = $dpr_obj->where('type', 3)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        foreach ($rsRecordList as $key => $value) {
            $value['status'] = $value['status'] == 2 ? '已完成' : '未完成';
        }
        return view('admin.distribute.agent_record', compact('rsRecordList'));
    }


}
