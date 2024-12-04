<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Pieza;
use Exception;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::latest()->get();
        return view('cliente.index', ['clientes' => $clientes]);
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
    public function store(StoreClienteRequest $request)
    {
        try {
            DB::beginTransaction();

            // Crear el cliente con los datos del request
            $cliente = Cliente::create($request->validated());

            DB::commit(); // Confirmar la transacción

            // Respuesta JSON para peticiones AJAX
            return response()->json($cliente, 201);
        } catch (Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error

            // Respuesta JSON para errores
            return response()->json(['message' => 'Error al crear cliente.'], 500);
        }
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
