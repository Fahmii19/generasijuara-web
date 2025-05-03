<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistribusiMapelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribusi_mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapel_id')
                ->nullable()
                ->constrained('mata_pelajaran')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('tutor_id')
                ->nullable()
                ->constrained('tutor')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('kelas_num');
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
        Schema::dropIfExists('distribusi_mapel');
    }
}
