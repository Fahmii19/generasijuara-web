<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Utils\Constant;
use App\Models\ElemenModel;

class ElemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Constant::ELEMEN;

        foreach ($data as $index => $subArray) {
            // echo "Index: $index\n";
            $dimensi_id = $index+1;
            foreach ($subArray as $value) {
                // echo "Value: $value\n";
                ElemenModel::create([
                    'dimensi_id' => $dimensi_id,
                    'elemen_name' => $value
                ]);
            }
            // echo "\n";
        }
        
    }
}
