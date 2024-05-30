<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballMatch extends Model
{
    use HasFactory;

    protected $fillable = ['play_date','play_time','team1_id','team2_id','finished','team1_goal','team2_goal','team1_yellow_card','team2_yellow_card','team1_red_card','team2_red_card'];

}
