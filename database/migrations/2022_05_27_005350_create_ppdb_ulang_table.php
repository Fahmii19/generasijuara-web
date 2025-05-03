<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpdbUlangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppdb_ulang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('kelas_sebelum_id')
                ->nullable()
                ->constrained('kelas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('kelas')->nullable();
            $table->string('semester')->nullable();
            $table->string('peminatan')->nullable();
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
            $table->double('wakaf', 18, 0)->nullable();
            $table->double('infaq', 18, 0)->nullable();
            $table->text('url_bukti_trf_zakat')->nullable();
            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppdb_ulang');
    }
}
