<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    /**
     * Busca un vendedor por ID y devuelve un error si no se encuentra.
     */
    private function findVendedor($id)
    {
        $vendedor = Vendedor::find($id);

        if (!$vendedor) {
            response()->json([
                'status' => false,
                'message' => 'Vendedor no encontrado',
            ], 404)->send();
            exit;
        }

        return $vendedor;
    }

    public function index()
    {
        $vendedores = Vendedor::all();
        return response()->json($vendedores);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|min:1|max:100',
            'correo' => 'required|string|email|max:60|unique:vendedors',
            'telefono' => 'nullable|string|max:25',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $vendedor = new Vendedor($request->all());
        $vendedor->save();

        return response()->json([
            'status' => true,
            'message' => 'Vendedor creado exitosamente',
            'data' => $vendedor,
        ], 200);
    }

    public function show($id)
    {
        $vendedor = $this->findVendedor($id);

        return response()->json([
            'status' => true,
            'data' => $vendedor,
        ]);
    }

    public function update(Request $request, $id)
    {
        $vendedor = $this->findVendedor($id);

        $rules = [
            'nombre' => 'nullable|string|min:1|max:100',
            'correo' => 'nullable|string|email|max:60',
            'telefono' => 'nullable|string|max:25',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $vendedor->update($request->only(['nombre', 'correo', 'telefono']));

        return response()->json([
            'status' => true,
            'message' => 'Vendedor actualizado exitosamente',
            'data' => $vendedor,
        ], 200);
    }

    public function destroy($id)
    {
        $vendedor = $this->findVendedor($id);

        $vendedor->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vendedor eliminado exitosamente',
        ], 200);
    }
}
