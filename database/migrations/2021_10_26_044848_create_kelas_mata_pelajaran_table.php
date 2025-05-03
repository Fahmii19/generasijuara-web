<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasMataPelajaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('mata_pelajaran_id')
                ->nullable()
                ->constrained('mata_pelajaran')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('tutor_id')
                ->nullable()
                ->constrained('tutor')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
        Schema::dropIfExists('kelas_mata_pelajaran');
    }
}
