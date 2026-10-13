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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained()->cascadeOnDelete();
            $table->string('payment_code')->unique(); // PKD-PAY-20261013-0001
            $table->enum('type', ['dp', 'pelunasan', 'denda', 'pembayaran_penuh'])->default('pembayaran_penuh');
            $table->decimal('amount', 12, 2);
            $table->enum('method', ['transfer_bank', 'qris', 'tunai', 'kartu_kredit'])->default('transfer_bank');
            $table->string('proof_file')->nullable(); // Bukti transfer
            $table->enum('status', ['menunggu_konfirmasi', 'diterima', 'ditolak'])->default('menunggu_konfirmasi');
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
