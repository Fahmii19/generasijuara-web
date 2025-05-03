<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahunAkademikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahun_akademik', function (Blueprint $table) {
            $table->id();
            $table->integer('kode')->unique();
            $table->string('tahun_ajar')->nullable();
            $table->string('keterangan')->nullable();
            $table->date('periode_start')->nullable();
            $table->date('periode_end')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
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
        Schema::dropIfExists('tahun_akademik');
    }
}
