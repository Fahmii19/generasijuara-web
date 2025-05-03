<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketSppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('semester', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('kode_smt')->nullable();
        //     $table->integer('id_thn_ajaran')->nullable();
        //     $table->string('nm_smt', 50)->nullable();
        //     $table->integer('smt')->nullable();
        //     $table->integer('a_periode_aktif')->nullable();
        //     $table->date('tgl_mulai')->nullable();
        //     $table->date('tgl_selesai')->nullable();
        //     $table->timestamps();
        // });

        Schema::create('paket_spp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_kelas_id')
                ->nullable()
                ->constrained('layanan_kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('paket_kelas_id')
                ->nullable()
                ->constrained('paket_kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->integer('semester')->nullable();
            $table->integer('kelas')->nullable();
            $table->double('biaya', 18, 2)->nullable();
            $table->double('biaya_program', 18, 2)->nullable();
            $table->double('biaya_pendaftaran', 18, 2)->nullable();
            $table->integer('jenis_pendaftaran')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('type')->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->timestamps();
        });

        // Schema::create('paket_spp_kelas', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('paket_spp_id')
        //         ->nullable()
        //         ->constrained('paket_spp')
        //         ->onUpdate('cascade')
        //         ->onDelete('set null');
        //     $table->string('kelas')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('paket_spp_kelas');
        Schema::dropIfExists('paket_spp');
        // Schema::dropIfExists('semester');
    }
}
