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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->string('winner')->nullable();
            $table->timestamps();
        });


        Schema::create('game_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->foreignId('game_id');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('game_user', function (Blueprint $table) {
            $table->foreignId('game_id');
            $table->foreignId('user_id');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_logs');
        Schema::dropIfExists('games');
        Schema::dropIfExists('game_user');
    }
};
