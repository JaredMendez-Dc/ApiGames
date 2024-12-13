<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Cliente::factory(10)->create();
        \App\Models\Inventario::factory(10)->create();
        \App\Models\Vendedor::factory(10)->create();
        \App\Models\Venta::factory(10)->create();
        \App\Models\Devolucion::factory(10)->create();

       /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
