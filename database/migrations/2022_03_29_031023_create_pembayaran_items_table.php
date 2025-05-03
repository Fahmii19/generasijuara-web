<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')
                ->nullable()
                ->constrained('pembayaran')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('item');
            $table->integer('nominal')->default(0);
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
        Schema::dropIfExists('pembayaran_items');
    }
}
