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
        User::factory(100)->create();
        Adm::factory(10)->create();
        Doctor::factory(10)->create();
        Attendant::factory(10)->create();
        Nurse::factory(10)->create();
    }
}