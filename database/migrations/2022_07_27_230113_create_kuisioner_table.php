<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuisionerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuisioner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')
                ->nullable()
                ->constrained('tahun_akademik')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('no_urut')->nullable();
            $table->text('item')->nullable();
            $table->string('input_type')->nullable();
            $table->string('input_value')->nullable();
            $table->text('input_label')->nullable();
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
        Schema::dropIfExists('kuisioner');
    }
}
