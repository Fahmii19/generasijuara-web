<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DimensiSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 1. Insert Dimensi
        $dimensi = [
            ['id' => 1, 'dimensi_name' => 'Berpikir Kritis', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'dimensi_name' => 'Kreativitas', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('dimensi')->insert($dimensi);

        // 2. Insert Elemen
        $elemen = [
            ['id' => 1, 'dimensi_id' => 1, 'elemen_name' => 'Analisis Informasi', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'dimensi_id' => 1, 'elemen_name' => 'Evaluasi Argumen', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'dimensi_id' => 2, 'elemen_name' => 'Ide Orisinal', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('elemen')->insert($elemen);

        // 3. Insert Capaian per fase (A–F)
        $capaian = [
            ['elemen_id' => 1, 'fase' => 'a', 'teks' => 'Mengidentifikasi informasi', 'created_at' => $now, 'updated_at' => $now],
            ['elemen_id' => 1, 'fase' => 'b', 'teks' => 'Menganalisis data sederhana', 'created_at' => $now, 'updated_at' => $now],
            ['elemen_id' => 2, 'fase' => 'a', 'teks' => 'Menilai pendapat orang lain', 'created_at' => $now, 'updated_at' => $now],
            ['elemen_id' => 3, 'fase' => 'c', 'teks' => 'Menyusun ide kreatif sendiri', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('capaian')->insert($capaian);
    }
}
