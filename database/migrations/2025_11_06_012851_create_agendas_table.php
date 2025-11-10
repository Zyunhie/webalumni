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
    Schema::create('agenda', function (Blueprint $table) {
        $table->id();
        $table->string('judul', 150);
        $table->text('deskripsi');
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai')->nullable();
        $table->string('lokasi', 150)->nullable();
        $table->string('gambar', 255)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
