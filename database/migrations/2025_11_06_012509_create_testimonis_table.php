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
    Schema::create('testimoni', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 100);
        $table->string('angkatan', 10)->nullable();
        $table->string('pekerjaan', 100)->nullable();
        $table->text('pesan');
        $table->string('foto', 255)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
