<?php

namespace Database\Seeders;

use App\Models\Adm;
use Illuminate\Database\Seeder;

class AdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Adm::insert([
            'id' => 1,
            'user_id' => 6,
            'active' => \Faker\Factory::create()->boolean(),
        ]);
    }
}
