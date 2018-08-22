<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'module';
    protected $primaryKey = 'moduleid';
    public $timestamps = false;


    //获取系统模块
    public function get_sys_modules(){

        $modules = $this->where('parentid', 0)
            ->where('type', 'module')
            ->where('listorder', 0)
            ->orderBy('listorder', 'asc')
            ->orderBy('moduleid', 'asc')
            ->get();

        return $modules;
    }

    //获取系统url页面二级导航
    public function get_sys_url_menu($modules){

        $menus = $this->where('parentid', '<>', 0)
            ->where('type', 'url')
            ->where('listorder', 0)
            ->orderBy('parentid', 'asc')
            ->orderBy('listorder', 'asc')
            ->orderBy('moduleid', 'asc')
            ->get();

        foreach($menus as $k => $v){
            if(!empty($modules[$v["parentid"]])){
                $type[$v["parentid"]]["type"][] = $v;
            }
        }
        $menus = $type;
        return $menus;
    }
}
