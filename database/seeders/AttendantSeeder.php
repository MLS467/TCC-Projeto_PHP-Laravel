<?php

namespace Database\Seeders;

use App\Models\Attendant;
use Illuminate\Database\Seeder;

class AttendantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendant::insert([
            'user_id' => 3,
            'id_administrator_fk' => 1,
            'active' => \Faker\Factory::create()->boolean()
        ]);
    }
}