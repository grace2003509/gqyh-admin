<?php
/**
 * 系统基本设置表
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected  $primaryKey = "id";
    protected  $table = "setting";
    public $timestamps = false;

    protected $fillable = ['sys_name','sys_logo','sys_copyright','sys_baidukey','sys_dommain'];


    // 多where
    public function scopeMultiwhere($query, $arr)
    {
        if (!is_array($arr)) {
            return $query;
        }

        foreach ($arr as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query;
    }


    //无需日期转换
    public function getDates()
    {
        return array();
    }
}
