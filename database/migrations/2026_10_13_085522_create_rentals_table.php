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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('rental_code')->unique(); // PKD-RN-20261013-0001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Penyewa
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained()->nullOnDelete(); // Opsional sopir
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('total_days');
            $table->decimal('car_cost', 12, 2);
            $table->decimal('driver_cost', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2); // car_cost + driver_cost - discount
            $table->decimal('down_payment', 12, 2)->default(0); // DP
            $table->decimal('remaining_balance', 12, 2)->default(0); // Sisa pelunasan
            $table->string('guarantee_type')->nullable(); // KTP, SIM, Motor+STNK, Paspor
            $table->string('guarantee_file')->nullable(); // Foto jaminan
            $table->text('pickup_location')->nullable();
            $table->text('dropoff_location')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', [
                'menunggu_konfirmasi', 
                'dikonfirmasi', 
                'sedang_berjalan', 
                'selesai', 
                'dibatalkan'
            ])->default('menunggu_konfirmasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
