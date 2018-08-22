<?php

namespace App\Http\Controllers\Admin\Base;

use App\Models\Module;
use App\Models\UsersConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SysUrlController extends Controller
{
    public function index(Request $request)
    {
        $get = $request->input();
        $module_obj = new Module();
        $modules = $module_obj->get_sys_modules();
        if(!empty($modules)){
            $default_array = current($modules);
            if(isset($get["module"])){
                $module = $get["module"];
            }else{
                $module = $default_array[0]["module"];
            }

            $type = isset($get["type"]) ? $get["type"] : (in_array($module,array('shop','article','web')) ? 'category' : '');
            $menus = $module_obj->get_sys_url_menu($modules);
        }else{
            return redirect()->back()->with('errors', '暂无模块，请联系维护人员');
        }

        $dialog = empty($get["dialog"]) ? 0 : 1;
        $input = empty($get["input"]) ? '' : $get["input"];
        $uc_obj = new UsersConfig();
        $users_dominfo=$uc_obj->get_dominfo();
        $rulreal = !empty($users_dominfo['domname']) && $users_dominfo['domenable'] == 1 ? $_SERVER["HTTP_HOST"] : $_SERVER["HTTP_HOST"];

        return view('admin.base.sys_url',
            compact('modules', 'module', 'menus', 'dialog', 'input', 'type', 'rulreal')
        );
    }
}
