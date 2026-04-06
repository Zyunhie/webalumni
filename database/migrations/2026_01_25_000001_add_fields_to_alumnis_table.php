<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom yang diperlukan untuk sistem alumni
     */
    public function up(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            // Kolom status untuk approval
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('prodi');
            
            // Relasi ke user (penambah data)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->after('status');
            
            // Kolom lulusan
            $table->year('lulusan')->nullable()->after('angkatan');
            
            // Kolom approval
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('user_id');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            
            // Kolom ijazah dan transkrip
            $table->string('ijazah', 255)->nullable()->after('foto');
            $table->string('transkrip', 255)->nullable()->after('ijazah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'status',
                'user_id',
                'lulusan',
                'approved_by',
                'approved_at',
                'ijazah',
                'transkrip'
            ]);
        });
    }
};

