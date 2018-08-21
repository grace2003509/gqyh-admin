<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeixinLog extends Model
{
    protected $table = 'weixin_log';
    protected $primaryKey = 'itemid';
    public $timestamps = false;

    protected $fillable = [
        'itemid', 'message', 'log_CreateTime', 'Order_ID'
    ];
}
