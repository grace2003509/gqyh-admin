<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Withdraw_Method;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WithdrawMethodController extends Controller
{
    const METHOD = array(
            'bank_card'=>'银行卡',
            'alipay'=>'支付宝',
            /*'wx_hongbao'=>'微信红包',
            'wx_zhuanzhang'=>'微信转账',*/
        );
    /**
     * 提现方法列表
     */
    public function index()
    {
        $dwm_obj = new Dis_Withdraw_Method();
        $_METHOD = self::METHOD;

        $method_list = $dwm_obj->orderBy('Method_CreateTime', 'desc')->paginate(15);
        foreach($method_list as $key => $value){
            $value['Method_Type'] = $_METHOD[$value['Method_Type']];
            $value['Method_CreateTime'] = date('Y-m-d H:i:s', $value['Method_CreateTime']);
        }

        return view('admin.distribute.withdraw_method', compact('method_list'));
    }


    /**
     * 添加提现方法页面
     */
    public function create()
    {
        $_METHOD = self::METHOD;
        return view('admin.distribute.withdraw_method_create', compact('_METHOD'));
    }

    /**
     * 添加提现方法
     */
    public function store(Request $request)
    {
        $_METHOD = self::METHOD;
        $dwm_obj = new Dis_Withdraw_Method();
        $input = $request->input();
        $rules = [
            'Name' => 'required_if:Type,bank_card|unique:distribute_withdraw_method,Method_Name'
        ];
        $message = [
            'Name.required_if' => '请填写银行名称',
            'Name.unique' => '提现方法不能重名'
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        if($input["Type"]  == 'bank_card'){
            $Method_Name = trim($input['Name']);
        }else{
            $Method_Name = $_METHOD[$input['Type']];
        }

        $data = array(
            "Users_ID"=>USERSID,
            "Method_Type"=>$input["Type"],
            "Method_Name"=>$Method_Name,
            "Status"=>$input['Status'],
            "Method_CreateTime"=>time(),
        );

        $flag = $dwm_obj->create($data);
        if($flag){
            return redirect()->route('admin.distribute.withdraw_method_index')->with('success', '添加成功');
        }else{
            return redirect()->back()->with('errors', '添加失败')->withInput();
        }
    }

    /**
     * 编辑提现方法页面
     */
    public function edit($id)
    {
        $_METHOD = self::METHOD;
        $dwm_obj = new Dis_Withdraw_Method();
        $method = $dwm_obj->find($id);
        return view('admin.distribute.withdraw_method_edit', compact('_METHOD', 'method'));
    }


    /**
     * 保存编辑的提现方法
     */
    public function update(Request $request, $id)
    {
        $_METHOD = self::METHOD;
        $dwm_obj = new Dis_Withdraw_Method();
        $input = $request->input();
        $rules = [
            'Name' => "required_if:Type,bank_card|unique:distribute_withdraw_method,Method_Name,{$id},Method_ID"
        ];
        $message = [
            'Name.required_if' => '请填写银行名称',
            'Name.unique' => '提现方法不能重名'
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        if($input["Type"]  == 'bank_card'){
            $Method_Name = trim($input['Name']);
        }else{
            $Method_Name = $_METHOD[$input['Type']];
        }
        $data = array(
            "Method_Type"=>$input["Type"],
            "Method_Name"=>$Method_Name,
            "Status"=>$input['Status']
        );
        $dwm_obj->where('Method_ID', $id)->update($data);

        return redirect()->route('admin.distribute.withdraw_method_index')->with('success', '保存成功');

    }

    /**
     * 删除提现方法
     */
    public function del($id)
    {
        $dwm_obj = new Dis_Withdraw_Method();

        $Flag = $dwm_obj->destroy($id);
        if($Flag){
            return redirect()->back()->with('success', '删除成功');
        }else{
            return redirect()->back()->with('errors', '删除失败');
        }

    }

}
