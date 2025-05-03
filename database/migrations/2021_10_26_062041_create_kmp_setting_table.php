<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKmpSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kmp_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kmp_id')
                ->nullable()
                ->constrained('kelas_mata_pelajaran')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->double('persentase_tm', 10, 2)->nullable();
            $table->double('persentase_um', 10, 2)->nullable();
            $table->integer('jumlah_modul')->nullable();
            $table->boolean('need_nilai_sikap')->nullable();
            $table->double('kkm', 10, 2)->default(70);
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
        Schema::dropIfExists('kmp_setting');
    }
}
