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
            $table->enum('dice1', [1, 2, 3, 4, 5, 6]);
            $table->enum('dice2', [1, 2, 3, 4, 5, 6]);
            $table->enum('gameResult', ['Won', 'Lose']);
            $table->foreignId('player_id') ->constrained() -> onDelete('cascade') ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
