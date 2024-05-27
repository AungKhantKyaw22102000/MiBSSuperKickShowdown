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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('back_number');
            $table->integer('goal')->nullable()->default(0);
            $table->integer('assist')->nullable()->default(0);
            $table->integer('club_id');
            $table->string('player_photo')->nullable();
            $table->integer('yellow_card')->nullable()->default(0);
            $table->integer('red_card')->nullable()->default(0);
            $table->date('date_of_birth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
