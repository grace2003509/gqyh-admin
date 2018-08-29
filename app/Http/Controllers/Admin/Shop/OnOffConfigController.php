<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\PermissionConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OnOffConfigController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');

        $pc_obj = new PermissionConfig();

        if(isset($type)){
            $pc_obj = $pc_obj->where('Perm_Tyle', $type);
        }else{
            $pc_obj = $pc_obj->where('Perm_Tyle', '<=', 2);
        }
        $perm_config = $pc_obj->where('Is_Delete', 0)
            ->orderBy('Perm_On', 'desc')
            ->get();

        $switchplace = array('非法操作','分销中心','个人中心','分销中心-二维码','产品详情','提交订单');

        return view('admin.shop.on_off_config', compact('perm_config', 'switchplace', 'type'));
    }

    public function store(Request $request)
    {
        $input = $request->input();

        $pc_obj = new PermissionConfig();
        $Data = array(
            'Users_ID' => USERSID,
            'Perm_Name' => $input['name'],
            'Perm_Picture' => $input['Logo'],
            'Perm_Url' => $input['http_url'],
            'Perm_Tyle' => $input['Tyle_IS'],
            'Perm_index' => $input['index'],
        );
        $flag = $pc_obj->create($Data);
        if($flag){
            return redirect()->back()->with('success', '添加成功');
        }else{
            return redirect()->back()->with('errors', '添加失败');
        }

    }


    public function update(Request $request, $id)
    {
        $input = $request->input();

        $pc_obj = new PermissionConfig();
        $Data = array(
            'Perm_Name' => $input['name'],
            'Perm_Picture' => $input['Logo'],
            'Perm_Url' => $input['http_url'],
            'Perm_Tyle' => $input['Tyle_IS'],
            'Perm_index' => $input['index'],
        );
        $pc_obj->where('Permission_ID', $id)->update($Data);

        return redirect()->back()->with('success', '修改成功');
    }

    public function edit_status($id)
    {
        $pc_obj = new PermissionConfig();
        $rst = $pc_obj->find($id);
        $status = ($rst['Perm_On']) == 1 ? 0 : 1;
        $flag = $rst->update(['Perm_On' => $status]);
        if($flag){
            return redirect()->back()->with('success', '修改成功');
        } else{
            return redirect()->back()->with('errors', '修改失败');
        }
    }

    public function del($id)
    {
        $pc_obj = new PermissionConfig();
        $flag = $pc_obj->destroy($id);
        if($flag){
            return redirect()->back()->with('success', '删除成功');
        } else{
            return redirect()->back()->with('errors', '删除失败');
        }
    }
}
