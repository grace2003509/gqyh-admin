<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebArticle extends Model
{
    protected  $primaryKey = "Article_ID";
    protected  $table = "web_article";
    public $timestamps = false;
}
