<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDisfrazRequest;
use App\Http\Requests\UpdateDisfrazRequest;
use App\Models\Categoria;
use App\Models\Disfraz;
use App\Models\Pieza;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DisfrazController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $piezas_tipo = Pieza::where('estado', 1) // Agrupamos las piezas activas por su tipo
            ->get()
            ->groupBy('tipo')
            ->map(function ($piezas) {
                return $piezas->map(function ($pieza) {
                    return [
                        'id' => $pieza->id,
                        'nombre' => $pieza->nombre,
                    ];
                });
            });
        $categorias = Categoria::all();
        $disfrazs = Disfraz::with(['categorias', 'piezas'])->latest()->get();

        return view('disfraz.index', compact('disfrazs', 'categorias', 'piezas_tipo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $piezas_tipo = Pieza::where('estado', 1)
            ->get()
            ->groupBy('tipo')
            ->map(function ($piezas) {
                return $piezas->map(function ($pieza) {
                    return [
                        'id' => $pieza->id,
                        'nombre' => $pieza->nombre,
                    ];
                });
            });

        $categorias = Categoria::where('estado', 1)->get();

        return view('disfraz.create', compact('categorias', 'piezas_tipo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDisfrazRequest $request)
    {
        try {
            DB::beginTransaction();

            // Handle image upload
            $imgPath = null;
            if ($request->hasFile('img_path')) {
                $imgPath = $this->handleUploadImage($request->file('img_path'));
            }

            // Create disfraz
            $disfraz = new Disfraz();
            $disfraz->fill(array_merge($request->only([
                'nombre',
                'nroPiezas',
                'cantidad',
                'descripcion',
                'color',
                'edad_min',
                'edad_max',
                'precio',
                'genero'
            ]), ['img_path' => $imgPath]));
            $disfraz->save();

            // Attach relationships
            if ($request->has('categorias')) {
                $disfraz->categorias()->attach($request->get('categorias'));
            }

            if ($request->has('piezas')) {
                $disfraz->piezas()->attach($request->get('piezas'));
            }

            DB::commit();
            return redirect()->route('disfrazs.index')->with('success', 'Disfraz registrado');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al crear disfraz: ' . $e->getMessage());
            return redirect()->route('disfrazs.index')->with('error', 'Error al registrar disfraz');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disfraz $disfraz)
    {
        $categorias = Categoria::where('estado', 1)->get();
        $piezas = Pieza::where('estado', 1)->get();

        return view('disfraz.edit', compact('disfraz', 'categorias', 'piezas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDisfrazRequest $request, Disfraz $disfraz)
    {
        try {
            DB::beginTransaction();

            // Handle image upload
            $imgPath = $disfraz->img_path;
            if ($request->hasFile('img_path')) {
                $imgPath = $this->handleUploadImage($request->file('img_path'));

                // Delete old image
                if (Storage::disk('public')->exists('disfrazs/' . $disfraz->img_path)) {
                    Storage::disk('public')->delete('disfrazs/' . $disfraz->img_path);
                }
            }

            // Update disfraz
            $disfraz->fill(array_merge($request->only([
                'nombre',
                'nroPiezas',
                'cantidad',
                'descripcion',
                'color',
                'edad_min',
                'edad_max',
                'precio',
                'genero'
            ]), ['img_path' => $imgPath]));
            $disfraz->save();

            // Sync relationships
            $disfraz->categorias()->sync($request->get('categorias', []));
            $disfraz->piezas()->sync($request->get('piezas', []));

            DB::commit();
            return redirect()->route('disfrazs.index')->with('success', 'Disfraz editado');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al editar disfraz: ' . $e->getMessage());
            return redirect()->route('disfrazs.index')->with('error', 'Error al editar disfraz');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $disfraz = Disfraz::find($id);

        if (!$disfraz) {
            return redirect()->route('disfrazs.index')->with('error', 'Disfraz no encontrado');
        }

        $disfraz->update(['estado' => !$disfraz->estado]);

        $message = $disfraz->estado ? 'Disfraz restaurado' : 'Disfraz eliminado';
        return redirect()->route('disfrazs.index')->with('success', $message);
    }

    /**
     * Handle image upload.
     */
    private function handleUploadImage($image)
    {
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/disfrazs', $fileName);
        return $fileName;
    }
}
