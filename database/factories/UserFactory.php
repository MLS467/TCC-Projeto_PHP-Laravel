<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Senha padrão
            'phone' => $this->faker->phoneNumber(),
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'sex' => $this->faker->randomElement(['male', 'female', 'other']),
            'birth' => $this->faker->date(),
            'photo' => $this->faker->imageUrl(),
            'place_of_birth' => $this->faker->city(),
            'city' => $this->faker->city(),
            'neighborhood' => $this->faker->word(),
            'street' => $this->faker->streetName(),
            'block' => $this->faker->buildingNumber(),
            'apartment' => $this->faker->word(),
            'role' => $this->faker->randomElement(['admin', 'user', 'manager']),
            'age' => $this->faker->numberBetween(18, 99),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}