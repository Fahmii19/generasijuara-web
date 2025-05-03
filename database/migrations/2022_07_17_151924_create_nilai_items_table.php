<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nilai_id')
                ->nullable()
                ->constrained('nilai')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('p_susulan_tugas_1')->nullable();
            $table->boolean('p_susulan_tugas_2')->nullable();
            $table->boolean('p_susulan_tugas_3')->nullable();
            $table->boolean('k_susulan_tugas_1')->nullable();
            $table->boolean('k_susulan_tugas_2')->nullable();
            $table->boolean('k_susulan_tugas_3')->nullable();
            $table->boolean('p_susulan_ujian_1')->nullable();
            $table->boolean('p_susulan_ujian_2')->nullable();
            $table->boolean('p_susulan_ujian_3')->nullable();
            $table->boolean('k_susulan_ujian_1')->nullable();
            $table->boolean('k_susulan_ujian_2')->nullable();
            $table->boolean('k_susulan_ujian_3')->nullable();
            $table->boolean('p_remedial_tugas_1')->nullable();
            $table->boolean('p_remedial_tugas_2')->nullable();
            $table->boolean('p_remedial_tugas_3')->nullable();
            $table->boolean('k_remedial_tugas_1')->nullable();
            $table->boolean('k_remedial_tugas_2')->nullable();
            $table->boolean('k_remedial_tugas_3')->nullable();
            $table->boolean('p_remedial_ujian_1')->nullable();
            $table->boolean('p_remedial_ujian_2')->nullable();
            $table->boolean('p_remedial_ujian_3')->nullable();
            $table->boolean('k_remedial_ujian_1')->nullable();
            $table->boolean('k_remedial_ujian_2')->nullable();
            $table->boolean('k_remedial_ujian_3')->nullable();
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
        Schema::dropIfExists('nilai_items');
    }
}
