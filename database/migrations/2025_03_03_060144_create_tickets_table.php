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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('cccd')->unique();
            $table->string('name');
            $table->string('mail')->unique();
            $table->foreignId('fly_id')->constrained('flights');
            $table->foreignId('luggage_id')->constrained('luggage');
            $table->foreignId('seat_id')->constrained('seats');
            $table->foreignId('food_id')->constrained('food');
            $table->decimal('price', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
