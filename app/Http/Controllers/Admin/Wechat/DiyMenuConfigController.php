<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Models\WechatMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiyMenuConfigController extends Controller
{
    public function index()
    {
        $MsgType=array(0=>"文字消息",1=>"图文消息",2=>"连接网址");

        $menu_obj = new WechatMenu();
        $ParentMenu = $menu_obj->where('Menu_ParentID', 0)
            ->orderBy('Menu_Index', 'asc')
            ->get();

        foreach($ParentMenu as $key => $value){
            $value["Menu_MsgType"] = $MsgType[$value["Menu_MsgType"]];
            $rsMenu = $menu_obj->where('Menu_ParentID', $value['Menu_ID'])
                ->orderBy('Menu_Index', 'asc')
                ->get();
            foreach($rsMenu as $rk => $rv){
                $rv['Menu_MsgType'] = $MsgType[$rv['Menu_MsgType']];
            }
            $value['rsMenu'] = $rsMenu;
        }

        return view('admin.wechat.diy_menu_config', compact('ParentMenu'));
    }


    public function add()
    {

    }


    public function store(Request $request)
    {

    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function del($id){

    }
}
