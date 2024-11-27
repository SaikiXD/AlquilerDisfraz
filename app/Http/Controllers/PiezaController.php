<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePiezaRequest;
use App\Http\Requests\UpdatePiezaRequest;
use App\Models\Pieza;
use Exception;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class piezaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $piezas = Pieza::latest()->get();
        return view('pieza.index', ['piezas' => $piezas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todas las conjuntos activas
        // Devolver la vista 'pieza.create' con las conjuntos
        return view('pieza.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePiezaRequest $request)
    {
        try {
            DB::beginTransaction();
            $pieza = new Pieza();
            $pieza->fill([
                'nombre' => $request->nombre,
                'tipo' => $request->tipo
            ]);
            $pieza->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return redirect()->route('piezas.index')->with('success', 'Pieza registrada');
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
    public function edit(Pieza $pieza)
    {
        // Obtener todas las categorías activas
        return view('pieza.edit',  ['pieza' => $pieza]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePiezaRequest $request, Pieza $pieza)
    {
        try {
            DB::beginTransaction();
            $pieza->fill([
                'nombre' => $request->nombre,
                'tipo' => $request->tipo

            ]);
            $pieza->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('piezas.index')->with('success', 'Pieza editado');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
