<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuisionerResponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuisioner_respon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ppdb_id')
                ->nullable()
                ->constrained('ppdb')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('kuisioner_id')
                ->nullable()
                ->constrained('kuisioner')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('value');
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
        Schema::dropIfExists('kuisioner_respon');
    }
}
