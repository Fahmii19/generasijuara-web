<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPpdbIdToPpdbUlang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppdb_ulang', function (Blueprint $table) {
            $table->foreignId('ppdb_id')
                ->after('user_id')
                ->nullable()
                ->constrained('ppdb')
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
        Schema::table('ppdb_ulang', function (Blueprint $table) {
            $table->dropColumn('ppdb_id');
        });
    }
}
