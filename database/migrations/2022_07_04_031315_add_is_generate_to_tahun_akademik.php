<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsGenerateToTahunAkademik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tahun_akademik', function (Blueprint $table) {
            $table->boolean('is_generate_rombel')
                    ->nullable()
                    ->after('is_active')
                    ->default(false);
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
            $table->dropColumn('is_generate_rombel');
        });
    }
}
