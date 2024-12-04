<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'ci' => $this->faker->unique()->numberBetween(1000000, 9999999),
            'gmail' => $this->faker->unique()->safeEmail,
            'direccion' => $this->faker->address,
            'celular' => $this->faker->unique()->numberBetween(60000000, 79999999),
            'estado' => 1, // Activo
        ];
    }
}
