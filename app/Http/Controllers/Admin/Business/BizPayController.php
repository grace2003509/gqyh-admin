<?php

namespace App\Http\Controllers\Admin\Business;

use App\Models\Biz;
use App\Models\Biz_Bond_Back;
use App\Models\Biz_Pay;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BizPayController extends Controller
{
    /**
     * 入驻支付列表
     */
    public function enter_pay(Request $request)
    {
        $bp_obj = new Biz_Pay();
        $b_obj = new Biz();
        $input = $request->input();

        //搜索
        if (isset($input['search']) && $input['search'] == 1) {
            if ($input['Biz_Account']) {
                $BizInfo = $b_obj->select('Biz_ID')->where('Biz_Account', $input['Biz_Account'])->first();
                if ($BizInfo) {
                    $bp_obj = $bp_obj->where('Biz_ID', $BizInfo['Biz_ID']);
                }else{
                    $bp_obj = $bp_obj->where('Biz_ID', '');
                }
            }
            if ($input['status'] != "all") {
                $bp_obj = $bp_obj->where('status', $input['status']);
            }
        }

        $lists = $bp_obj->where('type', 1)->orderByDesc('addtime')->paginate(15);

        $_Status = array(
            0=>'未付款',
            1=>'已付款'
        );

        return view('admin.business.enter_pay', compact('lists', '_Status'));
    }


    /**
     * 续费支付列表
     */
    public function charge_pay(Request $request)
    {
        $bp_obj = new Biz_Pay();
        $b_obj = new Biz();
        $input = $request->input();

        //搜索
        if (isset($input['search']) && $input['search'] == 1) {
            if ($input['Biz_Account']) {
                $BizInfo = $b_obj->select('Biz_ID')->where('Biz_Account', $input['Biz_Account'])->first();
                if ($BizInfo) {
                    $bp_obj = $bp_obj->where('Biz_ID', $BizInfo['Biz_ID']);
                }else{
                    $bp_obj = $bp_obj->where('Biz_ID', '');
                }
            }
            if ($input['status'] != "all") {
                $bp_obj = $bp_obj->where('status', $input['status']);
            }
        }

        $lists = $bp_obj->where('type', '<>',1)
            ->orderByDesc('addtime')
            ->paginate(15);

        $_Status = array(
            0=>'未付款',
            1=>'已付款'
        );
        return view('admin.business.charge_pay', compact('lists', '_Status'));
    }


    /**
     * 保证金退款列表
     */
    public function bail_back(Request $request)
    {
        $bbb_obj = new Biz_Bond_Back();
        $b_obj = new Biz();
        $sp_obj = new ShopCategory();
        $input = $request->input();

        $lists = $bbb_obj->orderByDesc('addtime')->paginate(15);

        $_Status = array(
            1=>'申请中',
            2=>'审核通过',
            3=>'已退款',
            -1=>'已驳回'
        );

        //审核通过
        if (isset($input['action']) && $input['action'] == 'read') {
            $biz = $bbb_obj->find($input['id']);
            $biz->status = 2;
            $Flag = $biz->save();
            if ($Flag) {
                return redirect()->back()->with('success', '审核成功');
            } else {
                return redirect()->back()->with('errors', '审核失败');
            }
        }

        //驳回
        if (isset($input['action']) && $input['action'] == 'back') {
            $biz = $bbb_obj->find($input['id']);
            $biz->status = -1;
            $Flag = $biz->save();

            if ($Flag) {
                return redirect()->back()->with('success', '驳回成功');
            } else {
                return redirect()->back()->with('errors', '驳回失败');
            }
        }

        //退款
        if (isset($input['action']) && $input['action'] == 'begin_pay') {

            $Flag1 = $bbb_obj->where('id', $input['id'])->update(["status"=>3]);

            $bizInfo = $b_obj->select('bond_free', 'Category_ID')->find($input['bizid']);
            if (empty($bizInfo)) {
                return redirect()->back()->with('errors', '该商家没有保证金,不能退款');
            }

            $backInfo = $bbb_obj->select('back_money')->find($input['id']);
            if ($bizInfo['bond_free'] < $backInfo['back_money']) {
                return redirect()->back()->with('errors', '该商家的保证金小于所退保证金,不能退款');
            }

            //begin删除需要保证金的类别
            $cate_arr = explode(',', $bizInfo['Category_ID']);
            $cate_id = $sp_obj->select('Category_ID')
                ->where('Category_Bond', '>', 0)
                ->whereIn('Category_ID', $cate_arr)
                ->get();
            $cate_arr2 = [];
            foreach($cate_id as $k => $v){
                if(in_array($v['Category_ID'], $cate_arr)){
                    $cate_arr2[] = $v['Category_ID'];
                }
            }
            $cate_diff = array_diff($cate_arr, $cate_arr2);
            $cate_str = implode(',', $cate_diff);
            //end

            $bond_free = $bizInfo['bond_free'] - $backInfo['back_money'];
            $biz_data = [
                'bond_free' => $bond_free,
                'Category_ID' => $cate_str
            ];
            $Flag2 = $b_obj->where('Biz_ID', $input['bizid'])->update($biz_data);

            if ($Flag1 && $Flag2) {
                return redirect()->back()->with('success', '退款成功');
            } else {
                return redirect()->back()->with('errors', '退款失败');
            }
        }

        return view('admin.business.bail_back', compact('lists', '_Status'));

    }


    /**
     * 保证金退款详情
     */
    public function bail_show($id)
    {
        $bbb_obj = new Biz_Bond_Back();

        $BizBackInfo = $bbb_obj->find($id);

        return view('admin.business.bail_show', compact('BizBackInfo'));
    }

}
