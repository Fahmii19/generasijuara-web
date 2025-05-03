<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpdbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppdb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('nisn')->nullable();
            $table->string('no_induk')->nullable();
            $table->integer('type')->nullable();
            $table->string('nis')->nullable();
            $table->string('nama')->nullable();
            $table->string('kelamin')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nik_siswa')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('hp_siswa')->nullable();
            $table->string('hp_ayah')->nullable();
            $table->string('hp_ibu')->nullable();
            $table->string('telegram_siswa')->nullable();
            $table->string('telegram_ayah')->nullable();
            $table->string('telegram_ibu')->nullable();
            $table->string('email')->nullable();
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
            $table->integer('tipe_kelas_sebelum')->nullable();
            $table->string('kelas_sebelum')->nullable();
            $table->string('smt_kelas_sebelum')->nullable();
            $table->string('kelas')->nullable();
            $table->string('smt_kelas')->nullable();
            $table->string('lulusan')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->foreignId('paket_spp_id')
                ->nullable()
                ->constrained('paket_spp')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->text('url_bukti_trf')->nullable();
            $table->text('url_bukti_trf2')->nullable();
            $table->double('biaya_daftar', 18, 0)->nullable();
            $table->double('biaya_spp', 18, 0)->nullable();
            $table->double('biaya', 18, 0)->nullable();
            $table->string('peminatan')->nullable();
            $table->double('wakaf', 18, 0)->nullable();
            $table->double('infaq', 18, 0)->nullable();
            $table->text('url_bukti_trf_zakat')->nullable();
            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->boolean('is_active')->default(true);
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppdb');
    }
}
