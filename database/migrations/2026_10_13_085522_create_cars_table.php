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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_category_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Toyota Avanza Veloz 2024
            $table->string('brand'); // Toyota
            $table->string('plate_number')->unique(); // B 1234 PKD
            $table->year('year');
            $table->string('color')->nullable();
            $table->enum('transmission', ['Manual', 'Automatic'])->default('Automatic');
            $table->enum('fuel_type', ['Bensin', 'Diesel', 'Hybrid', 'Listrik'])->default('Bensin');
            $table->integer('seating_capacity')->default(7);
            $table->decimal('price_per_day', 12, 2); // 350000
            $table->decimal('penalty_per_hour', 12, 2)->default(50000); // Denda telat per jam
            $table->string('image')->nullable();
            $table->text('features')->nullable(); // JSON atau teks fitur: AC, Bluetooth, Audio, Dashcam, Child Seat
            $table->enum('status', ['tersedia', 'disewa', 'perawatan', 'nonaktif'])->default('tersedia');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
