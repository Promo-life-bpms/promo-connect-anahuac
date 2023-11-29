<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create(
            [
                'name' => 'Proveedores Visibles',
                'slug' => 'providers',
                'value' => '',
            ]
        );
    }
}
