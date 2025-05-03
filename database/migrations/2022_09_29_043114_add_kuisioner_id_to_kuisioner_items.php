<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKuisionerIdToKuisionerItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kuisioner_items', function (Blueprint $table) {
            $table->foreignId('kuisioner_id')
                ->after('id')
                ->nullable()
                ->constrained('kuisioner')
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
        Schema::table('kuisioner_items', function (Blueprint $table) {
            $table->dropForeign('kuisioner_items_kuisioner_id_foreign');
            $table->dropColumn('kuisioner_id');
        });
    }
}
