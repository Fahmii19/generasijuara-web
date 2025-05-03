<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKuisionerRespon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kuisioner_respon', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign('kuisioner_respon_ppdb_id_foreign');
            $table->dropForeign('kuisioner_respon_kuisioner_id_foreign');

            $table->dropColumn('ppdb_id');
            $table->dropColumn('kuisioner_id');

            $table->foreignId('kuisioner_wb_id')
                ->after('id')
                ->nullable()
                ->constrained('kuisioner_wb')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('kuisioner_item_id')
                ->after('kuisioner_wb_id')
                ->nullable()
                ->constrained('kuisioner_items')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kuisioner_respon', function (Blueprint $table) {
            $table->dropForeign('kuisioner_respon_kuisioner_wb_id_foreign');
            $table->dropForeign('kuisioner_respon_kuisioner_item_id_foreign');

            $table->dropColumn('kuisioner_wb_id');
            $table->dropColumn('kuisioner_item_id');

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
        });
    }
}
