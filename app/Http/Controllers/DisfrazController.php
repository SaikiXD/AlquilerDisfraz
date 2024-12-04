<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreDisfrazRequest;
use App\Http\Requests\UpdateDisfrazRequest;
use App\Models\Categoria;
use App\Models\Disfraz;
use App\Models\Pieza;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class DisfrazController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disfrazs = Disfraz::with(['categorias'])->latest()->get();
        return view('disfraz.index', compact('disfrazs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $piezas = Pieza::where('estado', 1)->get();
        $tipos = Tipo::where('estado', 1)->get();
        $categorias = Categoria::where('estado', 1)->get();
        return view('disfraz.create', compact('categorias', 'tipos', 'piezas'));
    }
    public function getPiezas(Request $request)
    {
        $tipoId = $request->input('tipo_id');

        if (!$tipoId) {
            return response()->json(['error' => 'Tipo ID no proporcionado.'], 400);
        }
        $piezas = Pieza::where('tipo_id', $tipoId)->get(['id', 'nombre']);

        if ($piezas->isEmpty()) {
            return response()->json(['message' => 'No hay piezas para el tipo seleccionado.'], 404);
        }

        return response()->json($piezas);
    }
    public function store(StoreDisfrazRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'arrayidtipo.*' => 'required|exists:tipos,id',
                'arrayidpieza.*' => 'required|exists:piezas,id',
                'arraycantidad.*' => 'required|integer|min:1',
                'arraycolor.*' => 'required|string|max:50',
                'arraytalla.*' => 'required|string|max:10',
                'arraymaterial.*' => 'required|string|max:50',
            ], [
                'arrayidtipo.*.required' => 'El tipo de pieza es obligatorio.',
                'arrayidpieza.*.required' => 'La pieza es obligatoria.',
                'arraycantidad.*.required' => 'La cantidad es obligatoria.',
            ]);
            // Llenar tabla disfraces
            $name = null;
            if ($request->hasFile('img_path')) {
                $name = $this->handleUploadImage($request->file('img_path'));
            }

            // Crear el disfraz con los datos validados y el nombre de la imagen
            $disfraz = Disfraz::create(array_merge($request->validated(), ['img_path' => $name]));

            // Llenar tabla disfraz_pieza
            // 1. Recuperar los arrays
            $arrayPiezaId = $request->get('arrayidpieza');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayColor = $request->get('arraycolor');
            $arrayTalla = $request->get('arraytalla');
            $arrayMaterial = $request->get('arraymaterial');

            // 2. Realizar el llenado
            $sizeArray = count($arrayPiezaId);
            $cont = 0;
            while ($cont < $sizeArray) {
                // Asociar piezas al disfraz
                $disfraz->piezas()->syncWithoutDetaching([
                    $arrayPiezaId[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'color' => $arrayColor[$cont],
                        'talla' => $arrayTalla[$cont],
                        'material' => $arrayMaterial[$cont]
                    ]
                ]);
                // Si necesitas realizar otras operaciones relacionadas, puedes agregarlas aquí.
                $cont++;
            }
            //Tabla categoría producto
            $categorias = $request->get('categorias');
            $disfraz->categorias()->attach($categorias);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('disfrazs.index')->with('error', 'Hubo un error al guardar el disfraz.');
        }
        return redirect()->route('disfrazs.index')->with('success', 'Disfraz creado exitosamente.');
    }


    public function show(Disfraz $disfraz)
    {
        $disfraz->load(['piezas', 'categorias']); // Carga las relaciones de piezas y categorías

        return view('disfraz.show', compact('disfraz'));
    }


    public function edit(Disfraz $disfraz)
    {
        // Obtener todas las categorías activas
        $tipos = Tipo::where('estado', 1)->get();
        $categorias = Categoria::where('estado', 1)->get();
        return view('disfraz.edit', compact('categorias', 'tipos', 'disfraz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDisfrazRequest $request, Disfraz $disfraz)
    {
        try {
            // Inicia la transacción
            DB::beginTransaction();

            // Manejo de la imagen: Si se carga una nueva imagen
            if ($request->hasFile('img_path')) {
                // Sube la nueva imagen
                $newImageName = $this->handleUploadImage($request->file('img_path'));

                // Elimina la imagen anterior si existe
                if (Storage::disk('public')->exists('disfrazs/' . $disfraz->img_path)) {
                    Storage::disk('public')->delete('disfrazs/' . $disfraz->img_path);
                }

                // Actualiza el path de la imagen en el modelo
                $disfraz->img_path = $newImageName;
            }

            // Actualiza los datos principales del disfraz
            $disfraz->update([
                'nombre' => $request->input('nombre'),
                'descripcion' => $request->input('descripcion'),
                'genero' => $request->input('genero'),
                'precio' => $request->input('precio'),
            ]);

            // Sincronización de categorías
            $categorias = $request->input('categorias', []);
            $disfraz->categorias()->sync($categorias);

            // Sincronización de piezas (disfraz_pieza)
            $arrayPiezaId = $request->input('arrayidpieza', []);
            $arrayCantidad = $request->input('arraycantidad', []);
            $arrayColor = $request->input('arraycolor', []);
            $arrayTalla = $request->input('arraytalla', []);
            $arrayMaterial = $request->input('arraymaterial', []);

            $pivotData = [];
            for ($i = 0; $i < count($arrayPiezaId); $i++) {
                $pivotData[$arrayPiezaId[$i]] = [
                    'cantidad' => $arrayCantidad[$i],
                    'color' => $arrayColor[$i],
                    'talla' => $arrayTalla[$i],
                    'material' => $arrayMaterial[$i],
                ];
            }
            $disfraz->piezas()->sync($pivotData);

            // Confirma la transacción
            DB::commit();

            return redirect()->route('disfrazs.index')->with('success', 'Disfraz actualizado correctamente.');
        } catch (Exception $e) {
            // Revierte la transacción en caso de error
            DB::rollBack();

            // Loguea el error (opcional)
            Log::error('Error al actualizar disfraz: ' . $e->getMessage());

            return redirect()->route('disfrazs.index')->with('error', 'Hubo un error al actualizar el disfraz.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $disfraz = Disfraz::find($id);
        if ($disfraz->estado == 1) {
            Disfraz::where('id', $id)->update(['estado' => 0]);
            $message = 'Disfraz eliminado';
        } else {
            Disfraz::where('id', $id)->update(['estado' => 1]);
            $message = 'Disfraz Restaurado';
        }

        return redirect()->route('disfrazs.index')->with('success', $message);
    }

    private function handleUploadImage($image)
    {
        $path = 'disfrazs';
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs($path, $imageName, 'public');
        return $path . '/' . $imageName; // Guardar la ruta completa
    }
}
