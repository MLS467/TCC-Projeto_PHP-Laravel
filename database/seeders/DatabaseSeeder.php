<?php

namespace Database\Seeders;

use App\Models\Adm;
use App\Models\Attendant;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();
        Adm::factory(1)->create();
        // Doctor::factory(1)->create();
        // Attendant::factory(1)->create();
        // Nurse::factory(1)->create();
    }
}