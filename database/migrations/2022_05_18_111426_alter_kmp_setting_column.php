<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKmpSettingColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kmp_setting', function (Blueprint $table) {
            $table->integer('skk')->default(1);
            $table->double('k_persentase_tm', 10, 2)->default(100);
            $table->double('k_persentase_um', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kmp_setting', function (Blueprint $table) {
            $table->dropColumn('skk');
            $table->dropColumn('k_persentase_tm');
            $table->dropColumn('k_persentase_um');
        });
    }
}
