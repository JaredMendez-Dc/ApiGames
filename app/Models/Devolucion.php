<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    /** @use HasFactory<\Database\Factories\DevolucionFactory> */
    use HasFactory;
    protected $fillable = ['venta_id', 'motivo', 'estadodeljuego', 'juego_id'];
}
