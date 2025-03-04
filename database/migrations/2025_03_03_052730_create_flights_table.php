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
        Schema::create('flights', function (Blueprint $table) {
            $table->id(); // ID khóa chính tự động tăng
            $table->string('fromLocation'); // ID sân bay đi
            $table->string('toLocation'); // ID sân bay đến
            $table->time('departureTime'); // Giờ khởi hành
            $table->time('arrivalTime'); // Giờ đến
            $table->date('departureDay'); // Ngày khởi hành
            $table->decimal('originalPrice', 10, 2); // Giá gốc

            // Khóa ngoại liên kết với bảng airports
            $table->foreign('fromLocation')->references('id')->on('airports')->onDelete('cascade');
            $table->foreign('toLocation')->references('id')->on('airports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
