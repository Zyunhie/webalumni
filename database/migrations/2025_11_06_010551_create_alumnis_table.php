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
    Schema::create('alumni', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 100);
        $table->string('nim', 20)->nullable();
        $table->string('prodi', 50)->nullable();
        $table->year('angkatan')->nullable();
        $table->string('pekerjaan', 100)->nullable();
        $table->string('perusahaan', 100)->nullable();
        $table->string('email', 100)->nullable();
        $table->string('no_hp', 20)->nullable();
        $table->text('alamat')->nullable();
        $table->string('foto', 255)->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
