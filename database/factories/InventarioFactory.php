<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventario>
 */
class InventarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombrevideojuego' => $this->faker->word(),
            'genero' => $this->faker->word(),
            'clasificacion' => $this->faker->randomElement(['E', 'T', 'M']),
            'estudio' => $this->faker->company(),
            'precio' => $this->faker->randomFloat(2, 10, 1000),
            'imagen' => ' ',
        ];
    }
}
