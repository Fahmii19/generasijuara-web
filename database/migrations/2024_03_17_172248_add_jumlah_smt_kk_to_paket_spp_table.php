<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJumlahSmtKkToPaketSppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paket_spp', function (Blueprint $table) {
            $table->integer('jumlah_smt_kk')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paket_spp', function (Blueprint $table) {
            $table->dropColumn('jumlah_smt_kk');
        });
    }
}
