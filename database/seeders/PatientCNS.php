<?php

namespace Database\Seeders;

use App\Models\PatientCNS as ModelsPatientCNS;
use Illuminate\Database\Seeder;

class PatientCNS extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsPatientCNS::factory()->count(300)->create();
    }
}