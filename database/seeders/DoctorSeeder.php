<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::insert([
            [
                'user_id' => 4,
                'id_administrator_fk' => 1,
                'crm' => strtoupper(\Faker\Factory::create()->bothify('CRM####')),
                'specialty' => 'cardiologista',
                'active' => \Faker\Factory::create()->boolean(80)
            ],
            [
                'user_id' => 5,
                'id_administrator_fk' => 1,
                'crm' => strtoupper(\Faker\Factory::create()->bothify('CRM####')),
                'specialty' => 'pediatra',
                'active' => \Faker\Factory::create()->boolean(80)
            ],
        ]);
    }
}