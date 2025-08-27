<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*  $datos = Producto::all();
        return response()->json([
            'success' => true,
            'data' => $datos|
        ]); */

        // return Producto::select('id', 'nombre')->get();

        $datos = Producto::with('categoria:id,nombre')->get()->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'stock' => $producto->stock,
                'precio' => $producto->precio,
                'peso' => $producto->peso,
                'disponible' => $producto->disponible,
                'categoria' => $producto->categoria->nombre, // 👈 solo el nombre
            ];
        });
        //$datos = Producto::where('disponible', true)->count();
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
