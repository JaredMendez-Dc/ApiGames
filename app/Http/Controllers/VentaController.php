<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Busca una venta por ID y devuelve un error si no se encuentra.
     */
    private function findVenta($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            response()->json([
                'status' => false,
                'message' => 'Venta no encontrada',
            ], 404)->send();
            exit;
        }

        return $venta;
    }

    public function index()
    {
        $ventas = Venta::select(
            'ventas.*',
            'clientes.nombre as cliente',
            'vendedors.nombre as vendedor',
            'inventarios.nombrevideojuego as juego'
        )
        ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
        ->join('vendedors', 'vendedors.id', '=', 'ventas.vendedor_id')
        ->join('inventarios', 'inventarios.id', '=', 'ventas.juego_id')
        ->paginate(10);

        return response()->json($ventas);
    }

    public function store(Request $request)
    {
        $rules = [
            'cliente_id' => 'required|exists:clientes,id',
            'vendedor_id' => 'required|exists:vendedors,id',
            'juego_id' => 'required|exists:inventarios,id',
            'formadepago' => 'required|string|max:50',
            'fecha_de_compra' => 'required|date',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $venta = new Venta($request->all());
        $venta->save();

        return response()->json([
            'status' => true,
            'message' => 'Venta creada exitosamente',
            'data' => $venta,
        ], 200);
    }

    public function show($id)
    {
        $venta = $this->findVenta($id);

        $venta = Venta::select(
            'ventas.*',
            'clientes.nombre as cliente',
            'vendedors.nombre as vendedor',
            'inventarios.nombrevideojuego as juego'
        )
        ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
        ->join('vendedors', 'vendedors.id', '=', 'ventas.vendedor_id')
        ->join('inventarios', 'inventarios.id', '=', 'ventas.juego_id')
        ->where('ventas.id', $venta->id)
        ->first();

        return response()->json([
            'status' => true,
            'data' => $venta,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $venta = $this->findVenta($id);

        $rules = [
            'cliente_id' => 'required|exists:clientes,id',
            'vendedor_id' => 'required|exists:vendedors,id',
            'juego_id' => 'required|exists:inventarios,id',
            'formadepago' => 'required|string|max:50',
            'fecha_de_compra' => 'required|date',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $venta->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Venta actualizada correctamente',
            'data' => $venta,
        ], 200);
    }

    public function destroy($id)
    {
        $venta = $this->findVenta($id);

        try {
            $venta->delete();

            return response()->json([
                'status' => true,
                'message' => 'Venta eliminada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'No se pudo eliminar la venta, está relacionada con otros registros',
            ], 400);
        }
    }

    public function VentasByCliente()
    {
        $ventas = Venta::select(DB::raw('count(ventas.id) as count, clientes.nombre'))
            ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
            ->groupBy('clientes.nombre')
            ->get();

        return response()->json($ventas);
    }

    public function VentasByVendedor()
    {
        $ventas = Venta::select(DB::raw('count(ventas.id) as count, vendedors.nombre'))
            ->join('vendedors', 'vendedors.id', '=', 'ventas.vendedor_id')
            ->groupBy('vendedors.nombre')
            ->get();

        return response()->json($ventas);
    }

    public function VentasByJuego()
    {
        $ventas = Venta::select(DB::raw('count(ventas.id) as count, inventarios.nombrevideojuego as juego'))
            ->join('inventarios', 'inventarios.id', '=', 'ventas.juego_id')
            ->groupBy('inventarios.nombrevideojuego')
            ->get();

        return response()->json($ventas);
    }

    public function all()
    {
        $ventas = Venta::select(
            'ventas.*',
            'clientes.nombre as cliente',
            'vendedors.nombre as vendedor',
            'inventarios.nombrevideojuego as juego'
        )
        ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
        ->join('vendedors', 'vendedors.id', '=', 'ventas.vendedor_id')
        ->join('inventarios', 'inventarios.id', '=', 'ventas.juego_id')
        ->get();

        return response()->json($ventas);
    }
}
