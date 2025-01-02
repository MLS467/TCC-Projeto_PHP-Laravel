<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PatientModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::all()->random()->id;
        $id_attendant = 1;
        $blood_type = $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);

        return [
            'user_id' => $user_id,
            'id_attendant' => $id_attendant,
            'allegy' => $this->faker->text(100),
            'sugery_history' => $this->faker->text(100),
            'blood_type' => $blood_type,
            'emergency_contact' => $this->faker->phoneNumber
        ];
    }
}