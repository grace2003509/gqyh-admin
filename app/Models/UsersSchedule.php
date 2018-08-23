<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersSchedule extends Model
{
    protected $table = 'users_schedule';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Users_ID', 'Money', 'StartRunTime', 'RunType', 'LastRunTime', 'day', 'Status'
    ];
}
