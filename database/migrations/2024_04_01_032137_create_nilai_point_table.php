<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_point', function (Blueprint $table) {
            $table->id();
            $table->foreignId('point_id')
                ->nullable()
                ->constrained('point')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('kelas_wb_id')
                ->nullable()
                ->constrained('kelas_wb')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('point_nilai');
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
        Schema::dropIfExists('nilai_point');
    }
}
