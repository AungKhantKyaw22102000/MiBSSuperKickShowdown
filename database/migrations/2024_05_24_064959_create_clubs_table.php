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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('club_photo');
            $table->integer('played_match');
            $table->integer('win');
            $table->integer('draw');
            $table->integer('lose');
            $table->integer('goal_for');
            $table->integer('goal_against');
            $table->integer('goal_difference');
            $table->integer('points');
            $table->integer('yellow_card');
            $table->integer('red_card');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
