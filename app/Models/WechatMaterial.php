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
}
