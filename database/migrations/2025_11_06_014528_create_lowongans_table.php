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
    Schema::create('lowongan', function (Blueprint $table) {
        $table->id();
        $table->string('judul', 150);
        $table->text('deskripsi');
        $table->string('perusahaan', 150);
        $table->string('lokasi', 150)->nullable();
        $table->date('tanggal_posting')->nullable();
        $table->date('batas_lamaran')->nullable();
        $table->string('gambar', 255)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
