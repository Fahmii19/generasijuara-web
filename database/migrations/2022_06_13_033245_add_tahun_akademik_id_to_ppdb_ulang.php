<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTahunAkademikIdToPpdbUlang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb_ulang', function (Blueprint $table) {
            $table->foreignId('tahun_akademik_id')
                ->nullable()
                ->after('kelas_sebelum_id')
                ->constrained('tahun_akademik')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppdb_ulang', function (Blueprint $table) {
            $table->dropColumn('tahun_akademik_id');
        });
    }
}
