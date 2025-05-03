<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedDocumentFieldsToPpdb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb', function (Blueprint $table) {
            $table->tinyInteger('is_ktp_approved')->after('dokumen_ijasah')->nullable();
            $table->tinyInteger('is_akta_approved')->after('is_ktp_approved')->nullable();
            $table->tinyInteger('is_shun_skhun_approved')->after('is_akta_approved')->nullable();
            $table->tinyInteger('is_kk_approved')->after('is_shun_skhun_approved')->nullable();
            $table->tinyInteger('is_ijasah_approved')->after('is_kk_approved')->nullable();
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
                'is_ktp_approved',
                'is_akta_approved',
                'is_shun_skhun_approved',
                'is_kk_approved',
                'is_ijasah_approved',
            ]);
        });
    }
}
