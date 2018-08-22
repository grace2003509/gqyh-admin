<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected  $primaryKey = "Votes_ID";
    protected  $table = "votes";
    public $timestamps = false;
}
