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
        Schema::create('car_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->string('service_type'); // Ganti Oli, Servis Rem, Tune Up, Ganti Ban, Cuci & Salon
            $table->date('maintenance_date');
            $table->decimal('cost', 12, 2);
            $table->string('workshop_name')->nullable(); // Bengkel Resmi / Mitra
            $table->text('description')->nullable();
            $table->string('receipt_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_maintenances');
    }
};
