<?php

namespace Database\Seeders;

use App\Models\PpdbModel;
use Illuminate\Database\Seeder;

class StudentCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get ppdb data
        $ppdb = PpdbModel::all();

        // Looping ppdb data
        foreach ($ppdb as $data) {
            $nis = $data->nis;

            if (empty($nis)) {
                continue;
            }

            $extentions = 'png';
            $kartu_pelajar_path = '/kartu_pelajar/' . $nis;

            if (!file_exists(public_path('uploads') . $kartu_pelajar_path . '.' . $extentions)) {
                $extentions = 'jpg';
            }

            PpdbModel::where('id', $data->id)->update([
                'url_kartu_pelajar' => $kartu_pelajar_path . '.' . $extentions
            ]);
        }
    }
}
