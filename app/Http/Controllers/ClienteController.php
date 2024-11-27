<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Cliente;
use Exception;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with('persona')->get();
        return view('cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        try {
            DB::beginTransaction();
            $cliente = new Cliente();
            $cliente->fill([
                'nombre' => $request->nombre,
                'ci' => $request->ci,
                'gmail' => $request->gmail,
                'direccion' => $request->direccion,
                'celular' => $request->celular
            ]);
            $cliente->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return redirect()->route('clientes.index')->with('success', 'Cliente registrado');
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
    public function edit(Cliente $cliente)
    {
        return view('cliente.edit', ['cliente' => $cliente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {

        Cliente::where('id', $cliente->id)->update($request->validated());
        return redirect()->route('clientes.index')->with('success', 'Cliente editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $cliente = Cliente::find($id);
        if ($cliente->estado == 1) {
            Cliente::where('id', $id)->update(['estado' => 0]);
            $message = 'Cliente eliminado';
        } else {
            Cliente::where('id', $id)->update(['estado' => 1]);
            $message = 'Cliente Restaurado';
        }


        return redirect()->route('clientes.index')->with('success', $message);
    }
}
