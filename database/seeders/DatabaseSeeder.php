<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(SettingSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(LayananSeeder::class);
        $this->call(TahunAkademikSeeder::class);
        $this->call(PaketKelasSeeder::class);
        $this->call(DimensiSeeder::class);
    }
}
