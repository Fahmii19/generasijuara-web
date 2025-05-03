<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanProsesWbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_proses_wb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dimensi_id')
                ->nullable()
                ->constrained('dimensi')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('kelas_wb_id')
                ->nullable()
                ->constrained('kelas_wb')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->text('catatan_proses');
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
        Schema::dropIfExists('catatan_proses_wb');
    }
}
