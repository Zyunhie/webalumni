<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('prodi', 50)->nullable()->after('nim');
            $table->year('angkatan')->nullable()->after('prodi');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('angkatan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prodi', 'angkatan', 'status']);
        });
    }
};
