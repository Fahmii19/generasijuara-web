<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRombelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rombel', function (Blueprint $table) {
            $table->id();
            // id, ppdb_id, tahun_akademik_id, cabang_id, kelas_id, status (aktif, tidak_aktif), keterangan (cuti, mutasi, mengundurkan_diri)
            $table->foreignId('ppdb_id')
                ->nullable()
                ->constrained('ppdb')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('tahun_akademik_id')
                ->nullable()
                ->constrained('tahun_akademik')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('cabang_id')
                ->nullable()
                ->constrained('cabang')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->boolean('is_active')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('rombel');
    }
}
