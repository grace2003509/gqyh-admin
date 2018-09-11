<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dis_Agent_Area extends Model
{
    protected $primaryKey = "id";
    protected $table = "distribute_agent_areas";
    public $timestamps = false;
    protected $fillable = [
        'type', 'Users_ID', 'Account_ID', 'area_id', 'area_name', 'create_at', 'status'
    ];
}
