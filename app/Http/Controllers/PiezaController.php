<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePiezaRequest;
use App\Http\Requests\UpdatePiezaRequest;
use App\Models\Pieza;
use App\Models\Tipo;
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
        $piezas = Pieza::with('tipo')->latest()->get();
        return view('pieza.index', compact('piezas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos = Tipo::where('estado', 1)->get();
        return view('pieza.create', compact('tipos'));
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
                'tipo_id' => $request->tipo_id
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
        $tipos = Tipo::where('estado', 1)->get();
        return view('pieza.edit',  ['pieza' => $pieza, 'tipos' => $tipos]);
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
                'tipo_id' => $request->tipo_id

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
