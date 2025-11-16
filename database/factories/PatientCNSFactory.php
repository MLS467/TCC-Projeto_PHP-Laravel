<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientCNS>
 */
class PatientCNSFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cns' => $this->faker->numerify('###############'), // 15 dígitos
            'cpf' => $this->faker->unique()->numerify('###########'), // precisa faker-br ou helper custom
            'nome' => $this->faker->name(),
            'genero' => $this->faker->randomElement(['masculino', 'feminino']),
            'data_nascimento' => $this->faker->date('Y-m-d', '2026-01-01'),
            'endereco' => $this->faker->streetAddress(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->stateAbbr(),
            'cep' => $this->faker->unique()->numerify('#########'),
            'telefone' => $this->faker->phoneNumber()
        ];
    }
}