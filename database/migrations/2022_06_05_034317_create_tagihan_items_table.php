<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')
                ->nullable()
                ->constrained('tagihan')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->integer('nominal')->nullable();
            $table->string('item')->nullable();
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
        Schema::dropIfExists('tagihan_items');
    }
}
