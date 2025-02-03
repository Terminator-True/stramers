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
        Schema::create('user_user', function (Blueprint $table) {
            $table->foreignId('user_id_slave')->constrained('users');
            $table->foreignId('user_id_master')->constrained('users');
            $table->string('friendship_status');
            $table->timestamps();
            $table->primary(['user_id_slave', 'user_id_master']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_user');
    }
};
