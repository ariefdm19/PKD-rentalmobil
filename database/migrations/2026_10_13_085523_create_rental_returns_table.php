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
        Schema::create('rental_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inspector_id')->nullable()->constrained('users')->nullOnDelete(); // Petugas pemeriksa
            $table->dateTime('actual_return_date');
            $table->integer('delay_hours')->default(0); // Jam keterlambatan
            $table->decimal('delay_penalty', 12, 2)->default(0); // Denda telat
            $table->decimal('damage_penalty', 12, 2)->default(0); // Denda kerusakan/baret
            $table->decimal('fuel_penalty', 12, 2)->default(0); // Denda bensin kurang
            $table->decimal('other_penalty', 12, 2)->default(0);
            $table->decimal('total_penalty', 12, 2)->default(0);
            $table->string('fuel_level_return')->nullable(); // Penuh, 3/4, 1/2, 1/4, Kosong
            $table->enum('condition_status', ['sangat_baik', 'baik', 'baret_ringan', 'rusak_sedang', 'rusak_berat'])->default('baik');
            $table->text('condition_notes')->nullable();
            $table->string('condition_photo')->nullable();
            $table->enum('payment_status', ['lunas', 'belum_lunas'])->default('lunas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_returns');
    }
};
