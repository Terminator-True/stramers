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
        Schema::create('card_deck', function (Blueprint $table) {
            $table->foreignId('deck_id')->constrained();
            $table->foreignId('card_id')->constrained();
            $table->integer('quantity')->default(1);
            $table->primary(['deck_id', 'card_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_deck');
    }
};
