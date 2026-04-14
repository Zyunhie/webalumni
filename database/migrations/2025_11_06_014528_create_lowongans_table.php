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
Schema::create('lowongans', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('perusahaan');
        $table->string('lokasi');
        $table->text('deskripsi');
        $table->text('kualifikasi');
        $table->text('cara_melamar');
        $table->string('external_link')->nullable();
        $table->json('target_prodi')->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->boolean('is_internal')->default(true);
        $table->foreignId('posted_by')->constrained('users')->onDelete('cascade');
        $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
        $table->timestamp('approved_at')->nullable();
        $table->text('rejection_reason')->nullable();
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
