<?php

namespace App\Http\Controllers;

use App\Models\Devolucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevolucionController extends Controller
{
    /**
     * Busca una devolución por ID y devuelve una respuesta de error si no existe.
     */
    private function findDevolucion($id)
    {
        $devolucion = Devolucion::find($id);

        if (!$devolucion) {
            response()->json([
                'status' => false,
                'message' => 'Devolución no encontrada',
            ], 404)->send();
            exit;
        }

        return $devolucion;
    }

    public function index()
    {
        $devoluciones = Devolucion::select(
            'devolucions.*',
            'ventas.id as venta',
            'inventarios.nombrevideojuego as juego'
        )
        ->join('ventas', 'ventas.id', '=', 'devolucions.venta_id')
        ->join('inventarios', 'inventarios.id', '=', 'devolucions.juego_id')
        ->paginate(10);

        return response()->json($devoluciones);
    }

    public function store(Request $request)
    {
        $rules = [
            'venta_id' => 'required|exists:ventas,id',
            'motivo' => 'required|string|max:255',
            'estadodeljuego' => 'required|string|max:50',
            'juego_id' => 'required|exists:inventarios,id',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $devolucion = new Devolucion($request->all());
        $devolucion->save();

        return response()->json([
            'status' => true,
            'message' => 'Devolución creada exitosamente',
            'data' => $devolucion,
        ], 200);
    }

    public function show($id)
    {
        $devolucion = $this->findDevolucion($id);

        return response()->json([
            'status' => true,
            'data' => $devolucion,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $devolucion = $this->findDevolucion($id);

        $rules = [
            'venta_id' => 'nullable|exists:ventas,id',
            'motivo' => 'nullable|string|max:255',
            'estadodeljuego' => 'nullable|string|max:50',
            'juego_id' => 'nullable|exists:inventarios,id',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $devolucion->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Devolución actualizada correctamente',
            'data' => $devolucion,
        ], 200);
    }

    public function destroy($id)
    {
        $devolucion = $this->findDevolucion($id);

        try {
            $devolucion->delete();

            return response()->json([
                'status' => true,
                'message' => 'Devolución eliminada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'No se pudo eliminar la devolución, está relacionada con otros registros',
            ], 400);
        }
    }

    public function DevolucionesByVenta()
    {
        $devoluciones = Devolucion::select(DB::raw('count(devolucions.id) as count, ventas.id as venta'))
            ->join('ventas', 'ventas.id', '=', 'devolucions.venta_id')
            ->groupBy('ventas.id')
            ->get();

        return response()->json($devoluciones);
    }

    public function DevolucionesByEstado()
    {
        $devoluciones = Devolucion::select(DB::raw('count(devolucions.id) as count, estadodeljuego'))
            ->groupBy('estadodeljuego')
            ->get();

        return response()->json($devoluciones);
    }

    public function DevolucionesByJuego()
    {
        $devoluciones = Devolucion::select(DB::raw('count(devolucions.id) as count, inventarios.nombrevideojuego as juego'))
            ->join('inventarios', 'inventarios.id', '=', 'devolucions.juego_id')
            ->groupBy('inventarios.nombrevideojuego')
            ->get();

        return response()->json($devoluciones);
    }

    public function all()
    {
        $devoluciones = Devolucion::select(
            'devolucions.*',
            'ventas.id as venta',
            'inventarios.nombrevideojuego as juego'
        )
        ->join('ventas', 'ventas.id', '=', 'devolucions.venta_id')
        ->join('inventarios', 'inventarios.id', '=', 'devolucions.juego_id')
        ->get();

        return response()->json($devoluciones);
    }
}
