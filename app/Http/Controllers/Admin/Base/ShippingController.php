<?php

namespace App\Http\Controllers\Admin\Base;

use App\Models\ShopConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShopShippingCompany;
use Illuminate\Support\Facades\Validator;
use Overtrue\Pinyin\Pinyin;

class ShippingController extends Controller
{
    public function index()
    {
        $shipping_list = ShopShippingCompany::where('Biz_ID', 0)
            ->orderBy('Shipping_CreateTime')
            ->paginate(10);
        foreach($shipping_list as $k=>$v){
            $v['Shipping_CreateTime'] = date('Y-m-d', $v['Shipping_CreateTime']);
        }

        return view('admin.base.shipping', compact('shipping_list'));
    }



    public function store(Request $request)
    {
        $input = $request->input();

        $rules = [
            'Shipping_Name' => 'required|unique:shop_shipping_company,Shipping_Name'
        ];
        $messages = [
            'Shipping_Name.required' => '快递公司名称不能为空',
            'Shipping_Name.unique' => '快递公司名称不能重复',
        ];
        $des = [
            'Shipping_Name' => '快递公司名称'
        ];
        $validate = Validator::make($input, $rules, $messages, $des);
        if($validate->fails()){
            return redirect()->route('admin.base.shipping')->with('errors', $validate->messages());
        }

        $pinyin = new Pinyin();
        $code = $pinyin->abbr($input['Shipping_Name']);
        $code = strtoupper($code);
        $data = array(
            "Users_ID"=>USERSID,
            "Shipping_Name"=>$input['Shipping_Name'],
            "Shipping_Code"=>$code,
            "Shipping_Business"=>'express',
            "Shipping_Status"=>$input['Shipping_Status'],
            "Shipping_CreateTime"=>time(),
        );


        $Flagadd = ShopShippingCompany::create($data);

        if($Flagadd)
        {
            return redirect()->route('admin.base.shipping')->with('success', '添加成功');
        }else
        {
            return redirect()->route('admin.base.shipping')->with('errors', '添加失败');
        }

    }



    public function update(Request $request, $id)
    {

        $input = $request->input();

        $rules = [
            'Shipping_Name' => "required|unique:shop_shipping_company,Shipping_Name,{$id},Shipping_ID",
        ];
        $messages = [
            'Shipping_Name.required' => '快递公司名称不能为空',
            'Shipping_Name.unique' => '快递公司名称不能重复',
        ];
        $des = [
            'Shipping_Name' => '快递公司名称'
        ];
        $validate = Validator::make($input, $rules, $messages, $des);
        if($validate->fails()){
            return redirect()->route('admin.base.shipping')->with('errors', $validate->messages());
        }

        $pinyin = new Pinyin();
        $code = $pinyin->abbr($input['Shipping_Name']);
        $code = strtoupper($code);
        $data = array(
            "Shipping_Name"=>$input['Shipping_Name'],
            "Shipping_Code"=>$code,
            "Shipping_Business"=>'express',
            "Shipping_Status"=>$input['Shipping_Status']

        );

        $Flag = ShopShippingCompany::where('Shipping_ID', $id)->update($data);

        if($Flag)
        {
            return redirect()->route('admin.base.shipping')->with('success', '编辑成功');
        }else
        {
            return redirect()->route('admin.base.shipping')->with('errors', '编辑失败');
        }
    }



    public function destroy($id)
    {
        $flag = ShopShippingCompany::destroy($id);
        if($flag)
        {
            return redirect()->route('admin.base.shipping')->with('success', '删除成功');
        }else
        {
            return redirect()->route('admin.base.shipping')->with('errors', '删除失败');
        }
    }



    public function recovered()
    {

    }
}
