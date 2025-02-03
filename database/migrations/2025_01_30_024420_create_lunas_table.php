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
        Schema::create('lunas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->decimal('jumlah', 15, 2);
            $table->string('metode_pembayaran');
            $table->string('bukti_transfer')->nullable();
            $table->timestamp('tanggal_pelunasan')->useCurrent();
            $table->timestamps();

            $table->foreign('karyawan_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lunas');
    }
};
