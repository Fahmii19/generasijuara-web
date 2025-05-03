<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerkembanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perkembangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppdb_id')
                ->nullable()
                ->constrained('ppdb')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('kmp_id')
                ->nullable()
                ->constrained('kelas_mata_pelajaran')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('laporan')->nullable();
            $table->text('deskripsi')->nullable();
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
        Schema::dropIfExists('perkembangan');
    }
}
