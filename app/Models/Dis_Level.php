<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dis_Level extends Model
{
    protected  $primaryKey = "Users_ID";
    protected  $table = "distribute_level";
    public $timestamps = false;

    //获取会员的分销商等级
    function shop_distribute_level($fields = array()){

        $builder = $this->where('Level_ID','>', 0);
        if(count($fields) >0 ){
            if(!$builder->get()) return false;
            $shop_dis_level = $builder->get()->toArray();
        }else{
            if(!$builder->get()) return false;
            $shop_dis_level = $builder->get()->toArray();
        }

        $UserLevel[0]="普通用户";
        foreach($shop_dis_level as $k => $v){
            $UserLevel[$v['Level_ID']] = $v['Level_Name'];
        }

        return !empty($UserLevel)?$UserLevel:false;
    }

    //获取以level_id为键值的分销商级别设置数组
    public function get_dis_level()
    {
        $dis_level = array();
        $r = $this->orderBy('Level_ID', 'asc')->get();
        foreach($r as $k => $v){
            $dis_level[$v['Level_ID']] = $v;
        }
        return $dis_level;
    }


}
