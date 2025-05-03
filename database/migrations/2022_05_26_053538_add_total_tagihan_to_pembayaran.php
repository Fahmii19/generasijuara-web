<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalTagihanToPembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->integer('tagihan')->after('nominal')->default(0);
            $table->foreignId('voucher_id')
                ->after('tagihan')
                ->nullable()
                ->constrained('voucher')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->integer('total_tagihan')->after('voucher_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn(['tagihan', 'voucher_id', 'total_tagihan']);
        });
    }
}
