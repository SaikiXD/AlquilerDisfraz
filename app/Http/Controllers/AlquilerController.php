<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlquilerRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreClienteRequest;
use App\Models\Alquiler;
use App\Models\Cliente;
use App\Models\Disfraz;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;

class AlquilerController extends Controller
{
    public function index()
    {
        $alquilers = Alquiler::with(['disfrazs'])->latest()->get();
        return view('alquiler.index', compact('alquilers'));
    }
    public function create()
    {
        $disfrazs = Disfraz::all();
        foreach ($disfrazs as $disfraz) {
            // Obtener cantidad mínima de las piezas asociadas a este disfraz
            $cantidadMinima = DB::table('disfraz_pieza')
                ->join('piezas', 'disfraz_pieza.pieza_id', '=', 'piezas.id')
                ->where('disfraz_pieza.disfraz_id', $disfraz->id)
                ->min('disfraz_pieza.cantidad');

            // Añadir la cantidad mínima como atributo al disfraz
            $disfraz->cantidad_minima = $cantidadMinima ?? 0; // Por defecto 0 si no hay piezas
        }
        $clientes = Cliente::all();
        return view('alquiler.create', compact('disfrazs', 'clientes'));
    }
    public function store(StoreAlquilerRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'arraydisfraz.*' => 'required|exists:disfrazs,id',
                'arraycantidad.*' => 'required|integer|min:1',
                'arrayprecio.*' => 'required|integer|min:1',
            ], [
                'arraydisfraz.*.required' => 'El Disfraz es obligatorio.',
                'arraycantidad.*.required' => 'La cantidad es obligatoria.',
                'arrayprecio.*.required' => 'El precio es obligatoria.',
            ]);
            // Llenar tabla alquilers
            $name = null;
            if ($request->hasFile('img_path_garantia')) {
                $name = $this->handleUploadImage($request->file('img_path_garantia'));
            }
            $alquiler = Alquiler::create(array_merge($request->validated(), ['img_path_garantia' => $name]));

            // Recuperar los arrays del formulario
            $arrayDisfrazId = $request->get('arraydisfraz');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioUnitario = $request->get('arrayprecio');

            foreach ($arrayDisfrazId as $index => $disfrazId) {
                // Llenar la tabla 'alquiler_disfraz'
                $disfraz = Disfraz::findOrFail($disfrazId);
                $cantidadSolicitada = intval($arrayCantidad[$index]);
                $alquiler->disfrazs()->attach($disfrazId, [
                    'cantidad' => $arrayCantidad[$index],
                    'precio_unitario' => $arrayPrecioUnitario[$index],
                ]);

                // Actualizar el stock del disfraz
                foreach ($disfraz->piezas as $pieza) {

                    $cantidadMinima = DB::table('disfraz_pieza')
                        ->join('piezas', 'disfraz_pieza.pieza_id', '=', 'piezas.id')
                        ->where('disfraz_pieza.disfraz_id', $disfrazId)
                        ->min('disfraz_pieza.cantidad') ?? 0;

                    $nuevaCantidad = $cantidadMinima - $cantidadSolicitada;
                    if ($cantidadSolicitada > $cantidadMinima) {
                        throw new Exception("La cantidad solicitada ({$cantidadSolicitada}) supera el stock disponible ({$cantidadMinima}) para el disfraz con ID: {$disfrazId}.");
                    }
                    DB::table('disfraz_pieza')
                        ->where('disfraz_id', $disfrazId)
                        ->where('pieza_id', $pieza->id)
                        ->update(['cantidad' => $nuevaCantidad]);
                }
            }

            DB::commit();
            return redirect()->route('alquilers.index')->with('success', 'Alquiler creado exitosamente.');
        } catch (Exception $e) {
            Log::error('Error en el controlador:', ['message' => $e->getMessage()]);
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    private function handleUploadImage($image)
    {
        $path = 'alquilers';
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs($path, $imageName, 'public');
        return $path . '/' . $imageName; // Guardar la ruta completa
    }
}
