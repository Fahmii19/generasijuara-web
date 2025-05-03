<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDataPresensiToKelasWbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelas_wb', function (Blueprint $table) {
            $table->integer('izin')->default(0);
            $table->integer('sakit')->default(0);
            $table->integer('alpa')->default(0);
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
            $table->dropColumn('izin');
            $table->dropColumn('sakit');
            $table->dropColumn('alpa');
        });
    }
}
