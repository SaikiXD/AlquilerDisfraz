<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategotiaRequest;
use App\Models\Categoria;
use Exception;
use GuzzleHttp\Psr7\Message;
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
        } catch (Exception $e) {
            DB::rollback();
        }
        return redirect()->route('categorias.index')->with('success', 'Categoria registrada');
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
    public function edit(Categoria $categoria)
    {

        return view('categoria.edit', ['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategotiaRequest $request, Categoria $categoria)
    {
        Categoria::where('id', $categoria->id)->update($request->validated());
        return redirect()->route('categorias.index')->with('success', 'Categoria editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $categoria = Categoria::find($id);
        if ($categoria->estado == 1) {
            Categoria::where('id', $id)->update(['estado' => 0]);
            $message = 'Categoria eliminada';
        } else {
            Categoria::where('id', $id)->update(['estado' => 1]);
            $message = 'Categoria Restaurada';
        }


        return redirect()->route('categorias.index')->with('success', $message);
    }
}
