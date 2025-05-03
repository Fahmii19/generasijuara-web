<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('email')->nullable();
            $table->char('jenis_kelamin', 1)->nullable(); // 'l' for laki-laki, 'p' for perempuan
            $table->string('nama');
            $table->string('no_hp')->nullable();
            $table->unsignedBigInteger('tahun_akademik_id');
            $table->string('paket')->nullable(); // 'A', 'B', 'C'
            $table->boolean('lanjut_kuliah')->default(1); // 1 for 'ya', 0 for 'tidak'
            $table->string('nama_sekolah')->nullable();
            $table->string('surat_penerimaan')->nullable();
            $table->string('prodi')->nullable();
            $table->string('usaha')->nullable();
            $table->string('sertifikat')->nullable();
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
        Schema::dropIfExists('alumni');
    }
}
