<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCabangIdRombel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rombel', function (Blueprint $table) {
            $table->dropForeign('rombel_cabang_id_foreign');
            $table->dropColumn('cabang_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rombel', function (Blueprint $table) {
            $table->foreignId('cabang_id')
                ->nullable()
                ->constrained('cabang')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }
}
