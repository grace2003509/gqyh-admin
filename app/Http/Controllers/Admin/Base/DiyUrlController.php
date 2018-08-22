<?php

namespace App\Http\Controllers\Admin\Base;

use App\Models\WechatUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DiyUrlController extends Controller
{
    /**
     * 自定义url列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $url_obj = new WechatUrl();
        $rsUrls = $url_obj->orderBy('Url_ID', 'desc')->paginate(10);

        $id = $request->get('id');
        if($id > 0){
            $url_edit = $url_obj->find($id);
        }else{
            $url_edit = [];
        }
        return view('admin.base.diy_url', compact('rsUrls', 'url_edit'));
    }

    /**
     * 添加路径
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
            'Name' => 'required|string|max:50',
            'Value' => 'required|url'
        ];
        $messages = [
            'Name.required' => '路径名称不能为空',
            'Name.string' => '路径名称必须是字符串',
            'Name.max' => '路径名称超过最大字符数限制',
            'Value.required' => 'URL不能为空',
            'Value.url' => 'URL格式不正确'
        ];
        $validator = Validator::make($input, $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages());
        }

        $url_obj = new WechatUrl();
        $Data=array(
            "Url_Name"=>trim($input["Name"]),
            "Url_Value"=>trim($input["Value"]),
            "Users_ID"=>USERSID
        );
        $Flag=$url_obj->create($Data);

        if($Flag){
            return redirect()->back()->with('success', '添加成功');
        }else{
            return redirect()->back()->with('errors', '添加失败');
        }
    }

    /**
     * 编辑路径
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();
        $rules = [
            'Name' => 'required|string|max:50',
            'Value' => 'required|url'
        ];
        $messages = [
            'Name.required' => '路径名称不能为空',
            'Name.string' => '路径名称必须是字符串',
            'Name.max' => '路径名称超过最大字符数限制',
            'Value.required' => 'URL不能为空',
            'Value.url' => 'URL格式不正确'
        ];
        $validator = Validator::make($input, $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages());
        }

        $url_obj = new WechatUrl();
        $rst = $url_obj->find($id);
        $Data=array(
            "Url_Name"=>trim($input["Name"]),
            "Url_Value"=>trim($input["Value"]),
        );
        $Flag = $rst->update($Data);

        if($Flag){
            return redirect()->back()->with('success', '编辑成功');
        }else{
            return redirect()->back()->with('errors', '编辑失败');
        }
    }

    /**
     * 删除路径
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function del($id)
    {
        $url_obj = new WechatUrl();
        $Flag = $url_obj->destroy($id);
        if($Flag){
            return redirect()->back()->with('success', '删除成功');
        }else{
            return redirect()->back()->with('errors', '删除失败');
        }
    }
}
