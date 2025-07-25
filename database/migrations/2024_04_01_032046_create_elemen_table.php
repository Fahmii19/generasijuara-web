<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElemenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elemen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dimensi_id')
                ->nullable()
                ->constrained('dimensi')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('elemen_name', 255);
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
        Schema::dropIfExists('elemen');
    }
}
