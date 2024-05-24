<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['name','club_photo','played_match','win','draw','lose','goal_for','goal_against','goal_difference','points','yellow_card','red_card'];
}
