<?php

namespace App\Http\Controllers\Admin\Web;

use App\Models\Web_Article;
use App\Models\Web_Column;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * 微官网内容列表
     */
    public function index()
    {
        $wa_obj = new Web_Article();

        $articles = $wa_obj->orderBy('Article_Index', 'asc')
            ->orderBy('Article_ID', 'desc')->get();

        return view('admin.web.article', compact('articles'));
    }


    /**
     *微官网添加内容页面
     */
    public function create()
    {
        $wc_obj = new Web_Column();

        $Columns = $wc_obj->where('Column_ParentID', 0)
            ->orderBy('Column_Index', 'asc')->get();
        if (empty($Columns)) {
            return redirect()->route('admin.web.column_create')->with('errors', '没有栏目内容，去添加栏目吧');
        }

        foreach ($Columns as $key => $value) {
            $child = $wc_obj->where('Column_ParentID', $value['Column_ID'])
                ->orderBy('Column_Index', 'asc')->get();
            $value['child'] = $child;
        }

        return view('admin.web.article_create', compact('Columns'));
    }


    /**
     *微官网保存添加内容
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $wa_obj = new Web_Article();

        $rules = [
            'Index' => 'required|integer|min:0',
            'Title' => 'required|string|max:100',
        ];
        $message = [
            'Index.integer' => '序号必须是整数',
            'Index.min' => '序号不能小于0'
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $Data = array(
            "Article_Title" => $input['Title'],
            "Article_Index" => $input['Index'] ? intval($input['Index']) : 0,
            "Column_ID" => $input['Column_ID'],
            "Article_ImgPath" => $input['ImgPath'],
            "Article_Link" => empty($input['Link']) ? 0 : $input['Link'],
            "Article_LinkUrl" => $input["LinkUrl"],
            "Article_BriefDescription" => $input['BriefDescription'],
            "Article_Description" => $input['Description'],
            "Users_ID" => USERSID,
            "Article_CreateTime" => time()
        );
        $Flag = $wa_obj->create($Data);

        if ($Flag) {
            return redirect()->route('admin.web.article_index')->with('success', '添加成功');
        } else {
            return redirect()->back()->with('errors', '添加失败')->withInput();
        }

    }


    /**
     *微官网编辑内容页面
     */
    public function edit($id)
    {
        $wc_obj = new Web_Column();
        $wa_obj = new Web_Article();

        $Columns = $wc_obj->where('Column_ParentID', 0)
            ->orderBy('Column_Index', 'asc')->get();
        if (empty($Columns)) {
            return redirect()->route('admin.web.column_create')->with('errors', '没有栏目内容，去添加栏目吧');
        }

        foreach ($Columns as $key => $value) {
            $child = $wc_obj->where('Column_ParentID', $value['Column_ID'])
                ->orderBy('Column_Index', 'asc')->get();
            $value['child'] = $child;
        }

        $rsArticle = $wa_obj->find($id);

        return view('admin.web.article_edit', compact('Columns', 'rsArticle'));
    }


    /**
     *保存编辑内容
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();
        $wa_obj = new Web_Article();

        $rules = [
            'Index' => 'required|integer|min:0',
            'Title' => 'required|string|max:100',
        ];
        $message = [
            'Index.integer' => '序号必须是整数',
            'Index.min' => '序号不能小于0'
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $Data = array(
            "Article_Title" => $input['Title'],
            "Article_Index" => $input['Index'] ? intval($input['Index']) : 0,
            "Column_ID" => $input['Column_ID'],
            "Article_ImgPath" => $input['ImgPath'],
            "Article_Link" => empty($input['Link']) ? 0 : $input['Link'],
            "Article_LinkUrl" => $input["LinkUrl"],
            "Article_BriefDescription" => $input['BriefDescription'],
            "Article_Description" => $input['Description'],
        );
        $Flag = $wa_obj->where('Article_ID', $id)->update($Data);

        if ($Flag) {
            return redirect()->route('admin.web.article_index')->with('success', '编辑成功');
        }

    }


    /**
     * 删除内容
     */
    public function del($id)
    {
        $wa_obj = new Web_Article();
        $Flag = $wa_obj->destroy($id);
        if($Flag){
            return redirect()->back()->with('success', '删除成功');
        }else{
            return redirect()->back()->with('errors', '删除失败');
        }
    }


}
