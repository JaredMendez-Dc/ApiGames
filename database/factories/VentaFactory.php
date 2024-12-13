<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => $this->faker->numberBetween(1, 10),
            'vendedor_id' => $this->faker->numberBetween(1, 10),
            'juego_id' => $this->faker->numberBetween(1, 10),
            'formadepago' => $this->faker->randomElement(['tarjeta', 'efectivo']),
            'fecha_de_compra' => $this->faker->dateTimeThisYear(),
        ];
    }
}
