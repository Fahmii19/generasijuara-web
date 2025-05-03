<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCabangIdToPpdb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb', function (Blueprint $table) {
            $table->foreignId('cabang_id')
                ->nullable()
                ->after('id')
                ->constrained('cabang')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppdb', function (Blueprint $table) {
            $table->dropColumn('cabang_id');
        });
    }
}
