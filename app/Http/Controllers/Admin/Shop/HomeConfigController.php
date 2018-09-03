<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\ShopCategory;
use App\Models\ShopConfig;
use App\Models\ShopHome;
use App\Models\WechatMaterial;
use App\Models\WechatUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeConfigController extends Controller
{
    public function index()
    {
        $sc_obj = new ShopConfig();
        $sh_obj = new ShopHome();
        $rsConfig = $sc_obj->where('Users_ID', USERSID)->first();
        $rsSkin = $sh_obj->where('Skin_ID', $rsConfig['Skin_ID'])->first();
        $json=json_decode($rsSkin['Home_Json'],true);

        $s_cate = new ShopCategory();
        $ParentCategory = $s_cate->where('Category_ParentID', 0)
            ->orderBy('Category_Index', 'asc')
            ->get();
        foreach($ParentCategory as $key=>$value){
            $ParentCategory[$key]['rsCategory'] = $s_cate->where('Category_ParentID',$value["Category_ID"])
                ->orderBy('Category_Index', 'asc')
                ->get();
        }

        $UrlList = $this->UrlList();

        return view('admin.shop.home_config',
            compact('rsConfig', 'rsSkin', 'json', 'ParentCategory', 'UrlList'));

    }



    public function update(Request $request)
    {
        $input = $request->input();
        $do_action=empty($input['do_action'])?'':$input['do_action'];
        if($do_action=='shop.home_diy'){
            $Data=array(
                "Home_Json"=>str_replace('undefined','',$input["gruopPackage"])
            );
            $sc_obj = new ShopConfig();
            $rsConfig = $sc_obj->where('Users_ID', USERSID)->first();
            $sh_obj = new ShopHome();
            $Flag = $sh_obj->where('Skin_ID', $rsConfig['Skin_ID'])->update($Data);
            if($Flag){
                $response=array(
                    "status"=>"1"
                );
            }else{
                $response=array(
                    "status"=>"0"
                );
            }
            echo json_encode($response);
            exit;
        }
    }

    private function UrlList(){

            $html = '<option value="">--请选择--</option>';
	        $html .= '<optgroup label="------------------系统业务模块------------------"></optgroup>';
            $rsMaterial = WechatMaterial::select('Material_ID','Material_Table','Material_Json')
                ->where('Material_Table', '<>', 0)
                ->where('Material_TableID', 0)
                ->where('Material_Display', 0)
                ->orderBy('Material_ID', 'desc')
                ->get();
            foreach($rsMaterial as $k=>$v){
                $Material_Json=json_decode($v['Material_Json'],true);
                $html .= '<option value="'.$Material_Json["Url"].'">'.$Material_Json['Title'].'</option>';
            }
            $html .= '<optgroup label="------------------微商城产品分类页面------------------"></optgroup>';
            $ParentCategory = ShopCategory::where('Category_ParentID', 0)
                ->orderBy('Category_Index', 'asc')
                ->get();
            foreach($ParentCategory as $key=>$value){
                $rsCategory = ShopCategory::where('Category_ParentID', $value["Category_ID"])
                    ->orderBy('Category_Index', 'asc')
                    ->get();
                $html .= '<option value="/api/shop/category/'.$value["Category_ID"].'/">'.$value["Category_Name"].'</option>';
                foreach($rsCategory as $k => $v){
                    $html .= '<option value="/api/shop/category/'.$v["Category_ID"].'/">&nbsp;&nbsp;├'.$v["Category_Name"].'</option>';
                }
            }

            $html .= '<optgroup label="------------------自定义URL------------------"></optgroup>';
            $rsUrl = WechatUrl::all();
            foreach($rsUrl as $k => $v){
                $html .= '<option value="'.$v['Url_Value'].'">'.$v['Url_Name'].'('.$v['Url_Value'].')</option>';
            }

            return $html;
    }
}
