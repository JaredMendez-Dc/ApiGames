<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devolucions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onUpdate('cascade')->onDelete('restrict'); // Relación con la tabla ventas
            $table->string('motivo', 255); // Motivo de la devolución, con un límite de 255 caracteres
            $table->string('estadodeljuego', 50); // Estado del juego, valores como "nuevo", "usado", "defectuoso"
            $table->foreignId('juego_id')->constrained('inventarios')->onUpdate('cascade')->onDelete('restrict'); // Relación con la tabla inventario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucions');
    }
};
