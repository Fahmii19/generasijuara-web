<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaportSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raport_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('nama_ketua_pkbm')->nullable();
            $table->string('nip_ketua_pkbm')->nullable();
            $table->text('url_ttd_ketua')->nullable();
            $table->string('nama_pj_rombel')->nullable();
            $table->string('nip_pj_rombel')->nullable();
            $table->text('url_ttd_pj')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raport_setting');
    }
}
