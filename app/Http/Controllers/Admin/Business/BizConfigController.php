<?php

namespace App\Http\Controllers\Admin\Business;

use App\Models\Biz_Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BizConfigController extends Controller
{
    /**
     * 商家入驻描述设置页面
     */
    public function enter_describe()
    {
        $bc_obj = new Biz_Config();
        $item = $bc_obj->find(1);
        if (!$item) {
            $Data = array(
                "Users_ID" => USERSID,
                "BaoZhengJin" => "",
                "NianFei" => "",
                "JieSuan" => ""
            );
            $item = $bc_obj->create($Data);
        }

        return view('admin.business.enter_describe', compact('item'));

    }


    /**
     * 商家注册页面描述设置
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register_describe()
    {
        $bc_obj = new Biz_Config();
        $item = $bc_obj->find(1);
        if(!$item){
            $Data = array(
                "Users_ID"=>USERSID,
                "join_desc"=>"1",
            );
            $item = $bc_obj->create($Data);
        }

        return view('admin.business.register_describe', compact('item'));

    }


    /**
     * 年费设置
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function fee_describe()
    {
        $bc_obj = new Biz_Config();
        $bizConfig = $bc_obj->find(1);
        if (!$bizConfig) {
            return redirect()->route('admin.business.register_describe')->with('errors', '注册未设置');
        }
        $year_list = json_decode($bizConfig['year_fee'],true);

        return view('admin.business.fee_describe', compact('year_list'));

    }


    /**
     * 保存设置
     */
    public function describe_update(Request $request)
    {
        $bc_obj = new Biz_Config();
        $input = $request->input();

        if(isset($input['submit_enter']) && $input['submit_enter'] == 1){
            $Data = array(
                "BaoZhengJin"=>$input['BaoZhengJin'],
                "NianFei"=>$input['NianFei'],
                "JieSuan"=>$input['JieSuan'],
                "bond_desc"=>$input['bond_desc'],
                "mobile_desc"=>$input['mobile_desc']
            );

            $bc_obj->where('ItemID', 1)->update($Data);
        }

        if(isset($input['submit_register']) && $input['submit_register'] == 1){
            $Data = array(
                "join_desc"=>$input['join_desc'],
                "bannerimg"=>$input['bannerimg'],
            );

            $bc_obj->where('ItemID', 1)->update($Data);
        }

        if(isset($input['submit_fee']) && $input['submit_fee'] == 1){
            if (!isset($_POST['year_fee'])) {
                return redirect()->back()->with('errors', '请增加年费设置');
            }
            foreach ($_POST['year_fee']['name'] as $k => $v ) {
                if (!is_numeric($v) || $v < 0) {
                    return redirect()->back()->with('errors', '时间为大于0的数字');
                }
            }
            foreach ($_POST['year_fee']['value'] as $k => $v ) {
                if (!is_numeric($v) || $v < 0) {
                    return redirect()->back()->with('errors', '费用为大于0的数字');
                }
            }
            $Data = array(
                "year_fee"=>json_encode($input['year_fee'],JSON_UNESCAPED_UNICODE)
            );

            $bc_obj->where('ItemID', 1)->update($Data);
        }

        return redirect()->back()->with('success', '编辑成功');
    }


}
