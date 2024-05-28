<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name','back_number','goal','assist','club_id','player_photo','yellow_card','red_card','date_of_birth'];
}
