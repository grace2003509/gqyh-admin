<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatMaterial extends Model
{
    protected $table = 'wechat_material';
    protected $primaryKey = 'Material_ID';
    public $timestamps = false;

    protected $fillable = [
        'Material_ID', 'Users_ID', 'Material_Table', 'Material_TableID', 'Material_Display',
        'Material_Type','Material_Json','Material_CreateTime'
    ];



    public function get_sys_material($type)
    {
        //type为0时自定义图文，为1时系统图文
        $obj = $this->select('Material_ID','Material_Table','Material_Json','Material_Json');
        if($type == 1){
            $obj->where('Material_TableID', 0)
                ->where('Material_Table', '<>', '')
                ->where('Material_Display', 0);
        }else{
            $obj->select('Material_ID','Material_Table','Material_Json','Material_Json')
                ->where('Material_TableID', 0)
                ->where('Material_Table', '')
                ->where('Material_Display', 1);
        }
        $rst = $obj->orderBy('Material_ID','desc')->get();
        foreach($rst as $k => $v){
            $json=json_decode($v['Material_Json'],true);
            $v["Title"] = empty($json['Title']) ? (empty($json[0]['Title']) ? '' : $json[0]['Title']) : $json['Title'];
        }

        return $rst;
    }
}
