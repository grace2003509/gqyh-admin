<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Config;
use App\Models\Dis_Level;
use App\Models\ShopCategory;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawConfigController extends Controller
{
    /**
     * 提现设置展示页面
     */
    public function index()
    {
        $dc_obj = new Dis_Config();
        $sc_obj = new ShopCategory();
        $sp_obj = new ShopProduct();
        $dl_obj = new Dis_Level();

        $rsConfig = $dc_obj->find(1);

        //获取产品分类列表
        $category_list = $sc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_ParentID', 'asc')
            ->orderBy('Category_Index', 'asc')
            ->get();
        foreach($category_list as $key => $value){
            $child = $sc_obj->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_Index', 'asc')
                ->orderBy('Category_ID', 'asc')
                ->get();
            if($child){
                $value['child'] = $child;
            }
        }

        //分销商门槛、提现门槛初始化
        $withdraw_limit = array();
        $withdraw_limit[0] = 0;
        if($rsConfig["Withdraw_Type"]==2){
            $withdraw_limit = explode("|",$rsConfig["Withdraw_Limit"]);
        }

        $rsProduct = [];
        if($rsConfig["Withdraw_Type"]==2 && $withdraw_limit[0]==1 && !empty($withdraw_limit[1])){
            $rsProduct = $sp_obj->select('Products_Name', 'Products_ID', 'Products_PriceX')
                ->whereIn('', $withdraw_limit[1])
                ->get();
        }

        $distribute_level = $dl_obj->select('Level_ID','Level_Name')->get();

        return view('admin.distribute.withdraw_config', compact(
            'rsConfig', 'category_list', 'withdraw_limit', 'rsProduct', 'distribute_level'));
    }

    /**
     * 保存设置
     */
    public function update(Request $request)
    {
        $input = $request->input();
        $dc_obj = new Dis_Config();

        $dis_config = $dc_obj->find(1);
        //提现门槛
        $dis_config->Withdraw_Type = $input['Type'];
        $dis_config->Withdraw_Date = $input['Type_date'];
        if($input['Type']==2){
            $dis_config->Withdraw_Limit = $_POST["Fanwei"].'|'.(empty($input['Limit'][$input['Type']]) ? '' : substr($input['Limit'][$input['Type']],1,-1));
        }elseif($input['Type']==3){
            $dis_config->Withdraw_Limit = empty($input['Limit'][$input['Type']]) ? 0 : $input['Limit'][$input['Type']];
        }else{
            $dis_config->Withdraw_Limit = empty($input['Limit'][$input['Type']]) ? 0 : $input['Limit'][$input['Type']];
        }
        $dis_config->Withdraw_PerLimit = empty($input['PerLimit']) ? 0 : $input['PerLimit'];
        $dis_config->Balance_Ratio = empty($input['Balance_Ratio']) ? 0 : $input['Balance_Ratio'];
        $dis_config->Poundage_Ratio = empty($input['Poundage_Ratio']) ? 0 : $input['Poundage_Ratio'];
        $dis_config->TxCustomize = empty($input['TxCustomize']) ? 0 : $input['TxCustomize'];
        $dis_config->many_switch = empty($input['many_switch']) ? 0 : $input['many_switch'];

        $dis_config->save();

        return redirect()->route('admin.distribute.withdraw_config_index')->with('success', '保存成功');
    }
}
