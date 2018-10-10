<?php

namespace App\Http\Controllers\Admin\Web;

use App\Models\Web_Article;
use App\Models\Web_Column;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ColumnController extends Controller
{
    /**
     * 栏目列表
     */
    public function index()
    {
        $wc_obj = new Web_Column();

        $Columns = $wc_obj->where('Column_ParentID', 0)
            ->orderBy('Column_Index', 'asc')
            ->get();
        foreach($Columns as $key => $value){
            $child = $wc_obj->where('Column_ParentID', $value['Column_ID'])
                ->orderBy('Column_Index', 'asc')->get();
            if(count($child) > 0){
                $value['child'] = $child;
            }
        }
        return view('admin.web.column', compact('Columns'));
    }


    /**
     * 新建栏目页面
     */
    public function create()
    {
        $wc_obj = new Web_Column();

        $columns = $wc_obj->where('Column_ParentID', 0)
            ->orderBy('Column_Index', 'asc')->get();

        return view('admin.web.column_create', compact('columns'));
    }


    /**
     * 创建新栏目
     * @param Request $request
     */
    public function store(Request $request)
    {
        $wc_obj = new Web_Column();
        $input = $request->input();

        $rules = [
            'Index' => 'required|integer|min:0',
            'Name' => 'required|string|max:50',
        ];
        $message = [
            'Index.integer' => '栏目序号必需是整数',
            'Index.min' => '栏目序号不能小于0',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $Data=array(
            "Column_Index"=>$input['Index'] ? intval($input['Index']) : 0,
            "Column_ParentID"=>$input['ParentID'],
            "Column_Name"=>$input['Name'],
            "Column_PageType"=>$input['PageType'],
            "Column_ImgPath"=>$input["ImgPath"],
            "Column_Link"=>empty($input['Link'])?0:$input['Link'],
            "Column_LinkUrl"=>$input["LinkUrl"],
            "Column_PopSubMenu"=>empty($input['PopSubMenu'])?0:$input['PopSubMenu'],
            "Column_NavDisplay"=>empty($input['NavDisplay'])?0:$input['NavDisplay'],
            "Column_ListTypeID"=>empty($input['ListTypeID'])?0:$input['ListTypeID'],
            "Column_ChildTypeID"=>empty($input['ChildTypeID'])?0:$input['ChildTypeID'],
            "Column_Description"=>$input['Description'],
            "Users_ID"=>USERSID
        );
        $Flag = $wc_obj->create($Data);

        if($Flag){
            return redirect()->route('admin.web.column_index')->with('success', '添加成功');
        }else {
            return redirect()->back()->with('errors', '添加失败')->withInput();
        }
    }


    /**
     * 栏目详情页面
     * @param $id
     */
    public function edit($id)
    {
        $wc_obj = new Web_Column();

        $columns = $wc_obj->where('Column_ParentID', 0)
            ->orderBy('Column_Index', 'asc')->get();

        $rsColumn = $wc_obj->find($id);

        return view('admin.web.column_edit', compact('columns', 'rsColumn'));
    }


    /**
     * 编辑栏目
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $wc_obj = new Web_Column();
        $input = $request->input();

        $rules = [
            'Index' => 'required|integer|min:0',
            'Name' => 'required|string|max:50',
        ];
        $message = [
            'Index.integer' => '栏目序号必需是整数',
            'Index.min' => '栏目序号不能小于0',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $Data=array(
            "Column_Index"=>$input['Index'] ? intval($input['Index']) : 0,
            "Column_ParentID"=>$input['ParentID'],
            "Column_Name"=>$input['Name'],
            "Column_PageType"=>$input['PageType'],
            "Column_ImgPath"=>$input["ImgPath"],
            "Column_Link"=>empty($input['Link'])?0:$input['Link'],
            "Column_LinkUrl"=>$input["LinkUrl"],
            "Column_PopSubMenu"=>empty($input['PopSubMenu'])?0:$input['PopSubMenu'],
            "Column_NavDisplay"=>empty($input['NavDisplay'])?0:$input['NavDisplay'],
            "Column_ListTypeID"=>empty($input['ListTypeID'])?0:$input['ListTypeID'],
            "Column_ChildTypeID"=>empty($input['ChildTypeID'])?0:$input['ChildTypeID'],
            "Column_Description"=>$input['Description'],
        );
        $wc_obj->where('Column_ID', $id)->update($Data);

        return redirect()->route('admin.web.column_index')->with('success', '编辑成功');
    }


    /**
     * 删除栏目
     * @param $id
     */
    public function del($id)
    {
        $wc_obj = new Web_Column();
        $wa_obj = new Web_Article();

        $r_num = $wc_obj->where('Column_ParentID', $id)->count();

        if($r_num > 0){
            return redirect()->back()->with('errors', '该栏目下有子栏目,请勿删除');
        }else{
            $r_num = $wa_obj->where('Column_ID', $id)->count();
            if($r_num > 0){
                return redirect()->back()->with('errors', '该栏目下有内容,请勿删除');
            }else{
                $Flag = $wc_obj->destroy($id);
                if($Flag){
                    return redirect()->back()->with('success', '删除成功');
                }else{
                    return redirect()->back()->with('errors', '删除失败');
                }
            }
        }
    }



}
