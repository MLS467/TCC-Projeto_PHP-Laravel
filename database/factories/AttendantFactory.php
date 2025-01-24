<?php

namespace Database\Factories;

use App\Models\Adm;
use App\Models\Attendant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendant>
 */
class AttendantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $adm_id = Adm::all()->random()->id;

        $selectedUsers = session()->get('selected_users', []);
        $user_id = User::where('role', 'attendant')
            ->whereNotIn('id', $selectedUsers)  // Garante que o usuário não foi selecionado
            ->inRandomOrder()
            ->first();
        return [
            'user_id' => $user_id,
            'id_administrator_fk' => $adm_id,
            'active' => $this->faker->boolean()
        ];
    }
}