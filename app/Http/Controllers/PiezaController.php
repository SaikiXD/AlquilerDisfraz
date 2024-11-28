<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePiezaRequest;
use App\Http\Requests\UpdatePiezaRequest;
use App\Models\Pieza;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PiezaController extends Controller
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
            return redirect()->route('piezas.index')->with('success', 'Pieza registrada');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error al registrar pieza: ' . $e->getMessage());
            return redirect()->route('piezas.index')->with('error', 'Error al registrar la pieza');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pieza $pieza)
    {
        return view('pieza.edit', ['pieza' => $pieza]);
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
            return redirect()->route('piezas.index')->with('success', 'Pieza editada');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error al editar pieza: ' . $e->getMessage());
            return redirect()->route('piezas.index')->with('error', 'Error al editar la pieza');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pieza = Pieza::find($id);

            if (!$pieza) {
                return redirect()->route('piezas.index')->with('error', 'Pieza no encontrada');
            }

            $pieza->update(['estado' => !$pieza->estado]); // Cambia entre 1 y 0
            $message = $pieza->estado ? 'Pieza restaurada con éxito' : 'Pieza eliminada con éxito';

            return redirect()->route('piezas.index')->with('success', $message);
        } catch (Exception $e) {
            Log::error('Error al cambiar estado de la pieza: ' . $e->getMessage());
            return redirect()->route('piezas.index')->with('error', 'Error al eliminar/restaurar la pieza');
        }
    }
}
