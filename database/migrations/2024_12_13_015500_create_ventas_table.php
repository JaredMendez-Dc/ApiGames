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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onUpdate('cascade')->onDelete('restrict'); // Relación con clientes
            $table->foreignId('vendedor_id')->constrained('vendedors')->onUpdate('cascade')->onDelete('restrict'); // Relación con vendedores
            $table->foreignId('juego_id')->constrained('inventarios')->onUpdate('cascade')->onDelete('restrict'); // Relación con inventario (juegos)
            $table->string('formadepago', 50); // Forma de pago, string de 50 caracteres
            $table->datetime('fecha_de_compra'); // Fecha de compra como datetime
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
