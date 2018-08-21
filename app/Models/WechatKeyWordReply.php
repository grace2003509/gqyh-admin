<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatKeyWordReply extends Model
{
    protected $table = 'wechat_keyword_reply';
    protected $primaryKey = 'Reply_ID';
    public $timestamps = false;

    protected $fillable = [
        'Reply_ID','Users_ID','Reply_Table','Reply_TableID','Reply_Display','Reply_Keywords','Reply_PatternMethod',
        'Reply_MsgType','Reply_TextContents','Reply_MaterialID','Reply_CreateTime'
    ];
}
