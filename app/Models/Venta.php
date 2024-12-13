<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    /** @use HasFactory<\Database\Factories\VentaFactory> */
    use HasFactory;
    protected $fillable = ['cliente_id', 'vendedor_id', 'juego_id', 'formadepago', 'fecha_de_compra'];
}
