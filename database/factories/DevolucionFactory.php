<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Devolucion>
 */
class DevolucionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'venta_id' => $this->faker->numberBetween(1, 10),
            'motivo' => $this->faker->sentence(),
            'estadodeljuego' => $this->faker->randomElement(['nuevo', 'usado', 'defectuoso']),
            'juego_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
