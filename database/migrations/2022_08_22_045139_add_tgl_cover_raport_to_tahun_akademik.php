<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglCoverRaportToTahunAkademik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tahun_akademik', function (Blueprint $table) {
            $table->date('tgl_cover_raport')->after('tgl_raport')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tahun_akademik', function (Blueprint $table) {
            $table->dropColumn('tgl_cover_raport');
        });
    }
}
