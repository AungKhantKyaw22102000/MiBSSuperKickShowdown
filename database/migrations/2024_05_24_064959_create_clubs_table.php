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
            $table->string('club_photo')->nullable();
            $table->integer('played_match')->nullable()->default(0);
            $table->integer('win')->nullable()->default(0);
            $table->integer('draw')->nullable()->default(0);
            $table->integer('lose')->nullable()->default(0);
            $table->integer('goal_for')->nullable()->default(0);
            $table->integer('goal_against')->nullable()->default(0);
            $table->integer('goal_difference')->nullable()->default(0);
            $table->integer('points')->nullable()->default(0);
            $table->integer('yellow_card')->nullable()->default(0);
            $table->integer('red_card')->nullable()->default(0);
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
