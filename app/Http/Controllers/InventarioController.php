<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InventarioController extends Controller
{
    /**
     * Busca un inventario por ID y devuelve un error si no se encuentra.
     */
    private function findInventario($id)
    {
        $inventario = Inventario::find($id);

        if (!$inventario) {
            response()->json([
                'status' => false,
                'message' => 'Inventario no encontrado',
            ], 404)->send();
            exit;
        }

        return $inventario;
    }

    public function index()
    {
        $inventarios = Inventario::paginate(10);
        return response()->json($inventarios);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombrevideojuego' => 'required|string|max:100',
            'genero' => 'required|string|max:100',
            'clasificacion' => 'required|string|max:20',
            'estudio' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0|max:9999999.99',
            'imagen' => 'nullable|image|mimes:png,jpg|max:5120',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        $imagePath = null;

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imagePath = $image->store('imagenes_inventarios', 'public');
        }

        $inventario = new Inventario($request->all());
        $inventario->imagen = $imagePath ? Storage::url($imagePath) : null;
        $inventario->save();

        return response()->json([
            'status' => true,
            'message' => 'Inventario creado exitosamente',
            'data' => $inventario,
        ], 200);
    }

    public function show($id)
    {
        $inventario = $this->findInventario($id);

        return response()->json([
            'status' => true,
            'data' => $inventario,
        ]);
    }

    public function update(Request $request, $id)
    {
        $inventario = $this->findInventario($id);

        $rules = [
            'nombrevideojuego' => 'nullable|string|max:100',
            'genero' => 'nullable|string|max:100',
            'clasificacion' => 'nullable|string|max:20',
            'estudio' => 'nullable|string|max:100',
            'precio' => 'nullable|numeric|min:0|max:9999999.99',
            'imagen' => 'nullable|image|mimes:png,jpg|max:5120',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        if ($request->hasFile('imagen')) {
            if ($inventario->imagen && Storage::exists(str_replace('/storage/', '', $inventario->imagen))) {
                Storage::delete(str_replace('/storage/', '', $inventario->imagen));
            }

            $image = $request->file('imagen');
            $imagePath = $image->store('imagenes_inventarios', 'public');
            $inventario->imagen = Storage::url($imagePath);
        }

        $inventario->update($request->only([
            'nombrevideojuego',
            'genero',
            'clasificacion',
            'estudio',
            'precio',
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Inventario actualizado exitosamente',
            'data' => $inventario,
        ], 200);
    }

    public function destroy($id)
    {
        $inventario = $this->findInventario($id);

        if ($inventario->imagen && Storage::exists(str_replace('/storage/', '', $inventario->imagen))) {
            Storage::delete(str_replace('/storage/', '', $inventario->imagen));
        }

        $inventario->delete();

        return response()->json([
            'status' => true,
            'message' => 'Inventario eliminado correctamente',
        ], 200);
    }
}
