<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_kelas_id')
                ->nullable()
                ->constrained('layanan_kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('nama')->nullable();
            $table->string('kode')->nullable();
            $table->integer('type')->nullable();
            $table->double('biaya', 18, 0)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('kelas')->nullable();
            $table->integer('semester')->nullable();
            $table->foreignId('tahun_akademik_id')
                ->nullable()
                ->constrained('tahun_akademik')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreignId('paket_kelas_id')
                ->nullable()
                ->constrained('paket_kelas')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
        Schema::dropIfExists('kelas');
    }
}
