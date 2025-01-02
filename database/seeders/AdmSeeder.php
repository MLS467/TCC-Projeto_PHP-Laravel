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
        Adm::factory(10)->create();
    }
}