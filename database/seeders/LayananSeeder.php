<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LayananKelasModel;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $layanan = [
            [
                'kode' => 'HST',
                'nama' => 'HOMESCHOOLING TUNGGAL/MANDIRI',
            ],
            [
                'kode' => 'REG',
                'nama' => 'REGULAR',
            ],
            [
                'kode' => 'INTENSIF',
                'nama' => 'INTENSIF',
            ],
        ];
        foreach ($layanan as $key => $lk) {
            $db = LayananKelasModel::where('kode', $lk['kode'])->first();
            if (empty($db)) {
                $db = LayananKelasModel::create($lk);
            }
            $db->kode = $lk['kode'];
            $db->nama = $lk['nama'];
            $db->save();
        }
    }
}
