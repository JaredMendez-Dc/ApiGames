<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|min:1|max:100',
            'correo' => 'required|string|email|max:100|unique:clientes',
            'telefono' => 'nullable|string|max:25',
            'edad' => 'nullable|integer|min:0|max:120',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $cliente = new Cliente($request->all());
        $cliente->save();

        return response()->json([
            'status' => true,
            'message' => 'Cliente creado',
        ], 200);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'message' => 'El ID del cliente no es válido',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $cliente,
        ]);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'message' => 'El ID del cliente no es válido',
            ], 404);
        }

        $rules = [
            'nombre' => 'nullable|string|min:1|max:100',
            'correo' => 'nullable|string|email|max:100',
            'telefono' => 'nullable|string|max:25',
            'edad' => 'nullable|integer|min:0|max:120',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $cliente->update($request->only(['nombre', 'correo', 'telefono', 'edad']));

        return response()->json([
            'status' => true,
            'message' => 'Cliente actualizado',
        ], 200);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'message' => 'El ID del cliente no es válido',
            ], 404);
        }

        $cliente->delete();

        return response()->json([
            'status' => true,
            'message' => 'Cliente borrado',
        ], 200);
    }
}
