<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('kmp_id')
                ->nullable()
                ->constrained('kelas_mata_pelajaran')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('wb_id')
                ->nullable()
                ->constrained('ppdb')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->double('p_tugas_1', 10, 2)->nullable();
            $table->double('p_ujian_1', 10, 2)->nullable();
            $table->double('p_nilai_1', 10, 2)->nullable();
            $table->string('p_predikat_1')->nullable();
            $table->double('k_nilai_1', 10, 2)->nullable();
            $table->string('k_predikat_1')->nullable();
            $table->double('p_tugas_2', 10, 2)->nullable();
            $table->double('p_ujian_2', 10, 2)->nullable();
            $table->double('p_nilai_2', 10, 2)->nullable();
            $table->string('p_predikat_2')->nullable();
            $table->double('k_nilai_2', 10, 2)->nullable();
            $table->string('k_predikat_2')->nullable();
            $table->double('p_tugas_3', 10, 2)->nullable();
            $table->double('p_ujian_3', 10, 2)->nullable();
            $table->double('p_nilai_3', 10, 2)->nullable();
            $table->string('p_predikat_3')->nullable();
            $table->double('k_nilai_3', 10, 2)->nullable();
            $table->string('k_predikat_3')->nullable();
            $table->string('sikap_spiritual')->nullable();
            $table->text('sikap_spiritual_desc')->nullable();
            $table->string('sikap_sosial')->nullable();
            $table->text('sikap_sosial_desc')->nullable();
            $table->boolean('p_susulan_1')->nullable();
            $table->boolean('p_susulan_2')->nullable();
            $table->boolean('p_susulan_3')->nullable();
            $table->boolean('k_susulan_1')->nullable();
            $table->boolean('k_susulan_2')->nullable();
            $table->boolean('k_susulan_3')->nullable();
            $table->boolean('p_remedial_1')->nullable();
            $table->boolean('p_remedial_2')->nullable();
            $table->boolean('p_remedial_3')->nullable();
            $table->boolean('k_remedial_1')->nullable();
            $table->boolean('k_remedial_2')->nullable();
            $table->boolean('k_remedial_3')->nullable();
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
        Schema::dropIfExists('nilai');
    }
}
