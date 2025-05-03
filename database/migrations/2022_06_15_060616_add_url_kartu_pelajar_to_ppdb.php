<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlKartuPelajarToPpdb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb', function (Blueprint $table) {
            $table->text('url_kartu_pelajar')->after('url_bukti_trf2')->nullable();
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
            $table->dropColumn('url_kartu_pelajar');
        });
    }
}
