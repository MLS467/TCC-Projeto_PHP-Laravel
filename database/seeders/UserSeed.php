<?php

namespace Database\Seeders;

use App\Models\Attendant;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Nurse::factory(1)->create();
        Attendant::factory(1)->create();
        Doctor::factory(1)->create();
    }
}