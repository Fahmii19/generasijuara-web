<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProfilePpdb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb', function (Blueprint $table) {
            $table->string('tempat_lahir')->after('nik_ibu')->nullable();
            $table->date('tanggal_lahir')->after('tempat_lahir')->nullable();
            $table->string('status_dalam_keluarga')->after('tanggal_lahir')->nullable();
            $table->string('anak_ke')->after('status_dalam_keluarga')->nullable();
            $table->text('alamat_peserta_didik')->after('anak_ke')->nullable();
            $table->text('alamat_domisili')->after('alamat_peserta_didik')->nullable();
            $table->text('alamat_orang_tua')->after('alamat_domisili')->nullable();
            $table->string('no_telp_rumah')->after('alamat_orang_tua')->nullable();
            $table->string('agama')->after('no_telp_rumah')->nullable();
            $table->string('pekerjaan_ayah')->after('agama')->nullable();
            $table->string('pekerjaan_ibu')->after('pekerjaan_ayah')->nullable();
            $table->string('nama_wali')->after('telegram_ibu')->nullable();
            $table->string('no_telp_wali')->after('nama_wali')->nullable();
            $table->text('alamat_wali')->after('no_telp_wali')->nullable();
            $table->string('pekerjaan_wali')->after('alamat_wali')->nullable();
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
                'tempat_lahir',
                'tanggal_lahir',
                'status_dalam_keluarga',
                'anak_ke',
                'alamat_peserta_didik',
                'alamat_domisili',
                'alamat_orang_tua',
                'no_telp_rumah',
                'agama',
                'pekerjaan_ayah',
                'pekerjaan_ibu',
                'nama_wali',
                'no_telp_wali',
                'alamat_wali',
                'pekerjaan_wali',
            ]);
        });
    }
}
