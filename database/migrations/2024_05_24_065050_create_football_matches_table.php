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
            $table->tinyInteger('finished')->nullable();
            $table->integer('team1_goal')->nullable()->default(0);
            $table->integer('team2_goal')->nullable()->default(0);
            $table->integer('team1_yellow_card')->nullable()->default(0);
            $table->integer('team2_yellow_card')->nullable()->default(0);
            $table->integer('team1_red_card')->nullable()->default(0);
            $table->integer('team2_red_card')->nullable()->default(0);
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
