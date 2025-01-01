<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adm>
 */
class AdmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id_user = User::all()->random()->id;

        return [
            'user_id' => $id_user,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'work_start_date' => $this->faker->date(),
            'work_end_date' => $this->faker->date(),
        ];
    }
}