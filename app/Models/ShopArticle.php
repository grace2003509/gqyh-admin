<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopArticle extends Model
{
    protected  $primaryKey = "Article_ID";
    protected  $table = "shop_articles";
    public $timestamps = false;
}
