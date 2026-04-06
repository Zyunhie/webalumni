<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('testimoni', function (Blueprint $table) {
            $table->string('jurusan')->nullable()->after('nama');
            $table->year('tahun_lulus')->nullable()->after('jurusan');
            $table->string('perusahaan')->nullable()->after('pekerjaan');
            $table->text('isi_testimoni')->nullable()->after('pesan');
        });
    }

    public function down()
    {
        Schema::table('testimonis', function (Blueprint $table) {
            $table->dropColumn(['jurusan', 'tahun_lulus', 'perusahaan', 'isi_testimoni']);
        });
    }
};
?>

