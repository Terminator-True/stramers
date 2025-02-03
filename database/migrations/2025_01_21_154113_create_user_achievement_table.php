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
        Schema::create('user_achievement', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('achievement_id')->constrained();
            $table->timestamp('unlocked_at');
            $table->primary(['user_id', 'achievement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_achievement');
    }
};
