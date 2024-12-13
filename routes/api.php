<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;

Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Ventas
    Route::resource('ventas', VentaController::class);
    Route::get('ventasall', [VentaController::class, 'all']);
    Route::get('ventasbycliente', [VentaController::class, 'VentasByCliente']);
    Route::get('ventasbyvendedor', [VentaController::class, 'VentasByVendedor']);
    Route::get('ventasbyjuego', [VentaController::class, 'VentasByJuego']);

    // Vendedores
    Route::resource('vendedors', VendedorController::class);

    // Inventarios
    Route::resource('inventarios', InventarioController::class);

    // Devoluciones
    Route::resource('devolucions', DevolucionController::class);
    Route::get('devolucionesall', [DevolucionController::class, 'all']);
    Route::get('devolucionesbyventa', [DevolucionController::class, 'DevolucionesByVenta']);
    Route::get('devolucionesbymotivo', [DevolucionController::class, 'DevolucionesByEstado']);
    Route::get('devolucionesbyjuego', [DevolucionController::class, 'DevolucionesByJuego']);

    // Clientes
    Route::resource('clientes', ClienteController::class);

    // Logout
    Route::get('auth/logout', [AuthController::class, 'logout']);
});
