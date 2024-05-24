<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('football_matches', function (Blueprint $table) {
            $table->id();
            $table->date('play_date');
            $table->time('play_time');
            $table->tinyInteger('finished');
            $table->integer('team1_goal');
            $table->integer('team2_goal');
            $table->integer('team1_yellow_card');
            $table->integer('team2_yellow_card');
            $table->integer('team1_red_card');
            $table->integer('team2_red_card');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('football_matches');
    }
};
