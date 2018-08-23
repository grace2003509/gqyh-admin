<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'area_id';
    public $timestamps = false;

    protected $fillable = [
        'area_name', 'area_parent_id', 'area_sort', 'area_deep', 'area_region', 'area_code', 'letter'
    ];
}
