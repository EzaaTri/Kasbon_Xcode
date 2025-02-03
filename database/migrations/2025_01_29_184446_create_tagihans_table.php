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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pinjaman_id');
            $table->decimal('jumlah', 15, 2);
            $table->integer('jangka_waktu');
            $table->decimal('jumlah_per_bulan', 15, 2);
            $table->date('jatuh_tempo');
            $table->enum('status', ['belum_lunas', 'pending', 'lunas', 'terlambat']);
            $table->timestamps();

            $table->foreign('pinjaman_id')->references('id')->on('pinjaman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
