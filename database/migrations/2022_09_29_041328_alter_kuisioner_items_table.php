<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKuisionerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kuisioner_items', function (Blueprint $table) {
            // uncomment this after rollback
            // $table->dropForeign('kuisioner_items_tahun_akademik_id_foreign'); 
            $table->dropForeign('kuisioner_tahun_akademik_id_foreign');

            $table->dropColumn('tahun_akademik_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kuisioner_items', function (Blueprint $table) {
            $table->foreignId('tahun_akademik_id')
                ->nullable()
                ->constrained('tahun_akademik')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
}
