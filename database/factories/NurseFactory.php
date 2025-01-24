<?php

namespace Database\Factories;

use App\Models\Adm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nurse>
 */
class NurseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $selectedUsers = session()->get('selected_users', []);
        $user_id = User::where('role', 'nurse')
            ->whereNotIn('id', $selectedUsers)  // Garante que o usuário não foi selecionado
            ->inRandomOrder()
            ->first();
        $adm_id = Adm::all()->random()->id;

        return [
            'user_id' => $user_id,
            'id_administrator_fk' => $adm_id,
            'active' => $this->faker->boolean(),
            'coren' => $this->faker->bothify('########'),
            'specialty' => $this->faker->word,
        ];
    }
}