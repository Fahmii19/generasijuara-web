<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentsFieldToPpdb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb', function (Blueprint $table) {
            $table->text('dokumen_ktp_orang_tua')->after('paket_spp_id')->nullable();
            $table->text('dokumen_akta_kelahiran')->after('dokumen_ktp_orang_tua')->nullable();
            $table->text('dokumen_shun_skhun')->after('dokumen_akta_kelahiran')->nullable();
            $table->text('dokumen_kartu_keluarga')->after('dokumen_shun_skhun')->nullable();
            $table->text('dokumen_ijasah')->after('dokumen_kartu_keluarga')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppdb', function (Blueprint $table) {
            $table->dropColumn([
                'dokumen_ktp_orang_tua',
                'dokumen_akta_kelahiran',
                'dokumen_shun_skhun',
                'dokumen_kartu_keluarga',
                'dokumen_ijasah'
            ]);
        });
    }
}
