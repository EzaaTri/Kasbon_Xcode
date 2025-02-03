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
        Schema::create('pelunasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('users')->onDelete('cascade');
            $table->decimal('jumlah', 15, 2);
            $table->string('metode_pembayaran')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->enum('status', ['menunggu', 'ditolak', 'lunas'])->default('menunggu');
            $table->foreignId('tagihan_id')->constrained('tagihans')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelunasans');
    }
};
