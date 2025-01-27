<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('money')->default(0);
            $table->string('nick')->default('');
            $table->boolean('superadmin')->default(false);
            $table->string('avatar')->nullable();
            $table->string('background_profile')->nullable();
            $table->rememberToken();
            $table->string('socket_id')->nullable();
            $table->boolean('is_online')->default(false);
            $table->timestamp('last_online')->nullable();
            $table->boolean('is_banned')->default(false);
            $table->text('ban_reason')->nullable();
            $table->timestamp('ban_expires_at')->nullable();
            $table->integer('experience_points')->default(0);
            $table->integer('level')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
