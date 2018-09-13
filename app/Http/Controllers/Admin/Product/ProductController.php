<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Biz;
use App\Models\Dis_Config;
use App\Models\Dis_Level;
use App\Models\Shop_Product_Type;
use App\Models\ShopCategory;
use App\Models\ShopConfig;
use App\Models\ShopProduct;
use App\Models\UsersPayConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //商品类别
        $sc_obj = new ShopCategory();
        $shop_cate = $sc_obj->select('Category_ParentID', 'Category_ID', 'Category_Name')
            ->where('Category_ParentID', 0)
            ->orderBy('Category_ParentID', 'asc')
            ->orderBy('Category_Index', 'asc')
            ->get();
        foreach($shop_cate as $key => $value){
            $child = $sc_obj->select('Category_ParentID', 'Category_ID', 'Category_Name')
                ->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_ParentID', 'asc')
                ->orderBy('Category_Index', 'asc')
                ->get();
            if(count($child) > 0){
                $value['child'] = $child;
            }else{
                $value['child'] = [];
            }
        }

        //商家列表
        $b_obj = new Biz();
        $biz = $b_obj->select('Biz_ID', 'Biz_Name')->get();

        //产品列表
        $sp_obj = new ShopProduct();
        //搜索条件
        $input = $request->input();
        if(isset($input['search'])){
            if($input['Keyword']){
                $sp_obj = $sp_obj->where('Products_Name', 'like', "'%".$input['Keyword']."%'");
            }
            if ($input['SearchCateId'] != 0) {
                $cate = $sc_obj->find($input['SearchCateId']);
                if($cate['Category_ParentID'] == 0){
                    $cate_ids = $sc_obj->select('Category_ID')
                        ->where('Category_ParentID', $input['SearchCateId'])
                        ->get();
                    $sp_obj = $sp_obj->whereIn('Products_Category', $cate_ids);
                }else{
                    $sp_obj = $sp_obj->where('Products_Category', $input["SearchCateId"]);
                }
            }
            if($input['Status']<2){
                $sp_obj = $sp_obj->where('Products_Status', $input['Status']);
            }
            if($input['BizID']>0){
                $sp_obj = $sp_obj->where('Biz_ID', $input['BizID']);
            }
            if($input["Attr"]){
                $sp_obj = $sp_obj->where('Products_'.$input["Attr"], 1);
            }
        }
        $lists = $sp_obj->orderBy('Products_ID', 'desc')->paginate(10);
        foreach($lists as $k => $v){
            $v['json'] = json_decode($v['Products_JSON'],true);
            $v['rsBiz'] = $b_obj->select('Finance_Type', 'Finance_Rate','Biz_ID','Biz_Name')
                ->where('Biz_ID', $v["Biz_ID"])
                ->first();
            $v['web_precent1'] = $v["Products_PriceX"] * $v['Products_FinanceRate'];
            $v['web_precent2'] = $v["Products_PriceX"] - $v['Products_PriceS'];
            $v['web_precent'] = $v["Products_PriceX"] * $v['rsBiz']["Finance_Rate"];
            $v['web_money1'] = number_format($v['web_precent1']/100, 2, '.', '');
            $v['web_money2'] = number_format($v['web_precent2']/100, 2, '.', '');
            $v['web_money'] = number_format($v['web_precent']/100, 2, '.', '');
        }

        return view('admin.product.product', compact('shop_cate', 'biz', 'lists'));
    }


    /**
     * 商品详情页，编辑审核
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function audit($id)
    {
        $sp_obj = new ShopProduct();
        $sc_obj = new ShopCategory();
        $b_obj = new Biz();
        $dl_obj = new Dis_Level();
        $dc_obj = new Dis_Config();
        $spt_obj = new Shop_Product_Type();
        $c_obj = new ShopConfig();
        $upc_obj = new UsersPayConfig();

        $shop_config = $c_obj->find(USERSID);
        $rsProducts = $sp_obj->find($id);

        $shop_cate = $sc_obj->select('Category_ParentID', 'Category_ID', 'Category_Name')
            ->find($rsProducts['Products_Category']);
        $rsProducts['category_name'] = $shop_cate['Category_Name'];
        $rsProducts['json']=json_decode($rsProducts['Products_JSON'],true);

        $rsBiz = $b_obj->select('Group_ID','Finance_Type','Finance_Rate')->find($rsProducts["Biz_ID"]);

        //佣金设置信息
        $dislevelarrs = $dl_obj->select('Level_ID', 'Level_Name')
            ->orderBy('Level_ID', 'asc')
            ->get();
        $disidarr = [];
        foreach($dislevelarrs as $k => $v){
            $disidarr[] = $v['Level_ID'];
        }
        $jsondisidarr = json_encode($disidarr,JSON_UNESCAPED_UNICODE);
        $dislevelcont = count($dislevelarrs);
        $dis_config = $dc_obj->find(1);
        $level =  $dis_config['Dis_Self_Bonus']?$dis_config['Dis_Level']+1:$dis_config['Dis_Level'];
        $arr = array('一','二','三','四','五','六','七','八','九','十');

        //商品属性类型
        $rsTypes = $spt_obj->where('Biz_ID', $rsProducts["Biz_ID"])
            ->orderBy('Type_Index', 'asc')
            ->get();


        $Shop_Commision_Reward_Arr = array();
        if (!is_null($shop_config['Shop_Commision_Reward_Json'])) {
            $Shop_Commision_Reward_Arr = json_decode($shop_config['Shop_Commision_Reward_Json'], true);
        }
        $distribute_list = $rsProducts['Products_Distributes'] ? json_decode($rsProducts['Products_Distributes'],true) : array(); //分佣金额列表

        $rsConfig = $upc_obj->find(USERSID);//支付配置

        $ordertype = 0;
        if($rsProducts["Products_IsVirtual"]==1 && $rsProducts["Products_IsRecieve"]==1){
            $ordertype = 2;
        }elseif($rsProducts["Products_IsVirtual"]==1){
            $ordertype = 1;
        }

        $shop_category = $sc_obj->select('Category_ParentID', 'Category_ID', 'Category_Name')
            ->where('Category_ParentID', 0)
            ->orderBy('Category_ParentID', 'asc')
            ->orderBy('Category_Index', 'asc')
            ->get();
        foreach($shop_category as $key => $value){
            $child = $sc_obj->select('Category_ParentID', 'Category_ID', 'Category_Name')
                ->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_ParentID', 'asc')
                ->orderBy('Category_Index', 'asc')
                ->get();
            if(count($child) > 0){
                $value['child'] = $child;
            }else{
                $value['child'] = [];
            }
        }

        return view('admin.product.product_audit', compact(
            'rsProducts', 'rsBiz', 'dislevelarrs', 'jsondisidarr', 'level', 'arr', 'dis_config', 'rsTypes',
            'product_attr_html', 'rsConfig', 'ordertype', 'shop_category', 'dislevelcont', 'Shop_Commision_Reward_Arr',
            'distribute_list'));
    }

    public function update(Request $request, $id)
    {

    }


    public function active(Request $request)
    {
        $input = $request->input();
        if(isset($input['Products_ID'])) $productids = $input['Products_ID'];
        $sp_obj = new ShopProduct();
        //批量审核
        if ($input['action'] == 'audit') {
            $resupdate = array(
                "Products_Status"=>1
            );
            $Flag = $sp_obj->whereIn('Products_ID', $productids)->update($resupdate);
            if ($Flag) {
                $res = array(
                    "status"=>1,
                    "info"=>"批量审核成功！"
                );
                echo json_encode($res,JSON_UNESCAPED_UNICODE);
                exit;
            }
        }

        //批量设置积分抵用
        if ($input['action'] == 'inteegratseitch') {
            $rsfistproduct = $sp_obj->select('Integrationswitch')
                ->where('Products_ID', $input['Products_ID'][0])
                ->first();
            $resupdate = array(
                "Integrationswitch"=>$rsfistproduct['Integrationswitch']
            );
            $Flag = $sp_obj->whereIn('Products_ID', $productids)->update($resupdate);
            if ($Flag) {
                $res = array(
                    "status"=>1,
                    "info"=>"批量设置成功！"
                );
                echo json_encode($res,JSON_UNESCAPED_UNICODE);
                exit;
            }
        }

        //设置积分抵用单选
        if ($input['action'] == 'inteegratsimp') {
            if (!empty($_POST['dataid'])) {
                $Integrationswitch = 0;
                $showIntegrationswitch = '是';
            } else {
                $Integrationswitch = 1;
                $showIntegrationswitch = '否';
            }
            $resupdate = array(
                "Integrationswitch"=>$Integrationswitch
            );
            $Flag = $sp_obj->where('Products_ID', $input['proid'])->update($resupdate);
            if ($Flag) {
                $res = array(
                    "status"=>1,
                    "info"=>$showIntegrationswitch,
                    "infodataid"=>$Integrationswitch,
                    "proid"=>$input['proid']
                );
                echo json_encode($res,JSON_UNESCAPED_UNICODE);
                exit;
            }
        }

    }

    //商品佣金详情
    public function commission(Request $request)
    {
        $input = $request->input();
        $dl_obj = new Dis_Level();
        $dc_obj = new Dis_Config();
        $sp_obj = new ShopProduct();

        $ProductsID=empty($input['ProductsID'])?0:$input['ProductsID'];
        $rsProducts = $sp_obj->select('Products_Distributes', 'skuvaljosn', 'skujosn','Products_Count')
            ->find($ProductsID);

        $distribute_list = $rsProducts['Products_Distributes'] ? json_decode($rsProducts['Products_Distributes'],true) : array(); //分佣金额列表
        $dislevelarrs = $dl_obj->all();
        $dis_config = $dc_obj->find(1);
        $level =  $dis_config['Dis_Self_Bonus']?$dis_config['Dis_Level']+1:$dis_config['Dis_Level'];
        $arr = array('一','二','三','四','五','六','七','八','九','十');

        return view('admin.product.product_commission', compact(
            'dislevelarrs', 'dis_config', 'level', 'arr', 'distribute_list'));

    }


}
