<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebColumn extends Model
{
    protected  $primaryKey = "Column_ID";
    protected  $table = "web_column";
    public $timestamps = false;
}
