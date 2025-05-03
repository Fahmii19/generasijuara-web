<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Utils\Constant;
use App\Models\SettingsModel;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Constant::IMPORTANT_SETTINGS as $key => $value) {
            $setting = SettingsModel::where('key', $key)->first();
            if (empty($setting)) {
                $setting = SettingsModel::create([
                    'key' => $key,
                    'value' => $value,
                    'datatype' => Constant::DATATYPE_STRING,
                ]);
            }
        }
    }
}
