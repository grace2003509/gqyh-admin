<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    protected $primaryKey = "Battle_ID";
    protected $table = "battle";
    public $timestamps = false;

    protected $fillable = [
        'Users_ID','Battle_ID','Battle_Keywords','Battle_Title','Battle_ActivityName','Battle_QuestionNum',
        'Battle_AnswerQuertionNum','Battle_Integral','Battle_BackgroundMusic','Battle_MusicPath','Battle_IsSound',
        'Battle_LimitTime','Battle_StartTime','Battle_EndTime','Battle_LotteryTimes','Battle_EveryDayLotteryTimes',
        'Battle_Rule1','Battle_Rule2','Battle_Rule3','Battle_Rule4','Battle_Rule5','Battle_Game1','Battle_Game2',
        'Battle_Game3','Battle_Game4','Battle_Game5'
    ];
}
