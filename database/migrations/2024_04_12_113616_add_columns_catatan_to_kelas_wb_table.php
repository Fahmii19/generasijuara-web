<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsCatatanToKelasWbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelas_wb', function (Blueprint $table) {
            $table->text('catatan_perkembangan_profil_pelajar')->nullable();
            $table->text('catatan_perkembangan_pemberdayaan')->nullable();
            $table->text('catatan_perkembangan_keterampilan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelas_wb', function (Blueprint $table) {
            $table->dropColumn('catatan_perkembangan_profil_pelajar');
            $table->dropColumn('catatan_perkembangan_pemberdayaan');
            $table->dropColumn('catatan_perkembangan_keterampilan');
        });
    }
}
