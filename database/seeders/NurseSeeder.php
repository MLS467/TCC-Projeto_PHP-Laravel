<?php

namespace Database\Seeders;

use App\Models\Nurse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nurse::insert([
            'user_id' => 2,
            'id_administrator_fk' => 1,
            'active' => \Faker\Factory::create()->boolean(),
            'coren' => \Faker\Factory::create()->bothify('########'),
            'specialty' => \Faker\Factory::create()->word(),
        ]);
    }
}
