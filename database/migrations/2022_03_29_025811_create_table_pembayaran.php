<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('source_table')->nullable();
            $table->integer('source_id')->nullable();
            $table->integer('nominal')->default(0);
            $table->text('note')->nullable();
            $table->text('url_bukti_trf')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_approved')->default(false);
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
        Schema::dropIfExists('pembayaran');
    }
}
