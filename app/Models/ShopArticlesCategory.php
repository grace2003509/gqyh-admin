<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopArticlesCategory extends Model
{
    protected  $primaryKey = "Category_ID";
    protected  $table = "shop_articles_category";
    public $timestamps = false;
}
