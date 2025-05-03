<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Utils\Constant;
use App\Models\DimensiModel;

class DimensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Constant::DIMENSI;

        foreach ($data as $item) {
            DimensiModel::create([
                'dimensi_name' => $item
            ]);
        }
    }
}
