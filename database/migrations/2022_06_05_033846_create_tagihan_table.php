<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('source_table')->nullable();
            $table->string('source_id')->nullable();
            $table->foreignId('ppdb_id')
                ->nullable()
                ->constrained('ppdb')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->integer('tagihan')->nullable();
            $table->foreignId('voucher_id')
                ->nullable()
                ->constrained('voucher')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->integer('total_tagihan')->nullable();
            $table->integer('nominal')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('tagihan');
    }
}
