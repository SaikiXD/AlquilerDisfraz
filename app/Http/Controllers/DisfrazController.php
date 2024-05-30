<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class DisfrazController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('disfraz.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todas las categorías activas
        $categorias = Categoria::where('estado', 1)->get();
        // Devolver la vista 'disfraz.create' con las categorías
        return view('disfraz.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'edad_minima' => 'required|integer|min:0|max:120',
            'edad_maxima' => 'required|integer|min:0|max:120|gte:edad_minima',
        ], [
            'edad_minima.required' => 'La edad mínima es requerida.',
            'edad_minima.integer' => 'La edad mínima debe ser un número entero.',
            'edad_minima.min' => 'La edad mínima no puede ser negativa.',
            'edad_minima.max' => 'La edad mínima no puede ser mayor que 120.',
            'edad_maxima.required' => 'La edad máxima es requerida.',
            'edad_maxima.integer' => 'La edad máxima debe ser un número entero.',
            'edad_maxima.min' => 'La edad máxima no puede ser negativa.',
            'edad_maxima.max' => 'La edad máxima no puede ser mayor que 120.',
            'edad_maxima.gte' => 'La edad máxima debe ser mayor o igual que la edad mínima.',
            'precio.required' => 'El precio es requerido.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio no puede ser negativo.',
            'cantidad.required' => 'La cantidad es requerida.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad no puede ser negativa.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
