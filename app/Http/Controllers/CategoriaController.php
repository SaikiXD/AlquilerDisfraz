<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategotiaRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::latest()->get();
        return view('categoria.index', ['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        try {
            DB::beginTransaction();

            $categoria = new Categoria();
            $categoria->fill([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);
            $categoria->save();

            DB::commit();
            return redirect()->route('categorias.index')->with('success', 'Categoria registrada');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('categorias.index')->with('error', 'Error al registrar la categoria');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categoria.edit', ['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategotiaRequest $request, Categoria $categoria)
    {
        try {
            $categoria->update($request->validated());
            return redirect()->route('categorias.index')->with('success', 'Categoria editada');
        } catch (Exception $e) {
            return redirect()->route('categorias.index')->with('error', 'Error al editar la categoria');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return redirect()->route('categorias.index')->with('error', 'Categoria no encontrada');
        }

        $categoria->update(['estado' => !$categoria->estado]); // Cambia entre 1 y 0
        $message = $categoria->estado ? 'Categoria restaurada' : 'Categoria eliminada';

        return redirect()->route('categorias.index')->with('success', $message);
    }
}
