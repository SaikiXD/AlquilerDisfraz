<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreVentaRequest;
use App\Models\Alquiler;
use App\Models\Cliente;
use App\Models\Disfraz;
use App\Models\Garantia;
use Illuminate\Http\Request;
use Exception;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Alquiler::with(['garantia', 'cliente.persona', 'user'])
            ->where('estado', 1)
            ->latest()
            ->get();
        return view('venta.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $disfrazs = Disfraz::where('estado', 1)->where('cantidad', '>', '0')->get();
        $garantias = Garantia::all();
        $clientes = Cliente::WhereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();
        return view('venta.create', compact('disfrazs', 'clientes', 'garantias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {

        try {
            DB::beginTransaction();

            //Llenar mi tabla venta
            $venta = Alquiler::create($request->validated());

            //Llenar mi tabla venta_producto
            //1. Recuperar los arrays
            $arrayDisfraz_id = $request->get('arrayiddisfraz');
            $arrayCantidad = $request->get('arraycantidad');

            //2.Realizar el llenado
            $siseArray = count($arrayDisfraz_id);
            $cont = 0;

            while ($cont < $siseArray) {
                $venta->disfrazs()->syncWithoutDetaching([
                    $arrayDisfraz_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont]
                    ]
                ]);

                //Actualizar stock
                $disfraz = Disfraz::find($arrayDisfraz_id[$cont]);
                $stockActual = $disfraz->cantidad;
                $cantidad = intval($arrayCantidad[$cont]);

                DB::table('disfrazs')
                    ->where('id', $disfraz->id)
                    ->update([
                        'cantidad' => $stockActual - $cantidad
                    ]);

                $cont++;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return redirect()->route('ventas.index')->with('success', 'Alquilado exitosamente');
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
