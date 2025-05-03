<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaketKelasModel;
use App\Utils\Constant;

class PaketKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paketKelas = [
            [
                'nama' => 'PAKET A (Setara SD)',
                'kode' => 'PAKETA',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_ABC,
            ],
            [
                'nama' => 'PAKET B (Setara SMP)',
                'kode' => 'PAKETB',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_ABC,
            ],
            [
                'nama' => 'PAKET C (Setara SMA)',
                'kode' => 'PAKETC',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_ABC,
            ],
            [
                'nama' => 'SHIDDIQ',
                'kode' => 'SHIDDIQ',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_PAUD,
            ],
            [
                'nama' => 'AMANAH',
                'kode' => 'AMANAH',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_PAUD,
            ],
            [
                'nama' => 'KABAR',
                'kode' => 'KABAR',
                'is_active' => true,
                'type' => Constant::TYPE_KELAS_PAUD,
            ],
        ];
        foreach ($paketKelas as $key => $pk) {
            $db = PaketKelasModel::where('kode', $pk['kode'])->first();
            if (empty($db)) {
                $db = PaketKelasModel::create($pk);
            }else{
                $db->update($pk);
            }
        }
    }
}
