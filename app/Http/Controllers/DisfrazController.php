<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreDisfrazRequest;
use App\Http\Requests\UpdateDisfrazRequest;
use App\Models\Categoria;
use App\Models\Disfraz;
use App\Models\Pieza;
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
        // Obtener todas las categorías activas
        $categorias = Categoria::where('estado', 1)->get();
        // Devolver la vista 'disfraz.create' con las categorías
        return view('disfraz.create', compact('categorias'));
    }

    public function store(StoreDisfrazRequest $request)
    {
        /*try {
            DB::beginTransaction();
            //disfraz
            $disfraz = new Disfraz();
            if ($request->hasFile('img_path')) {
                $name = $disfraz->hanbleUploadImage($request->file('img_path'));
            } else {
                $name = null;
            }
            $disfraz->fill([
                'nombre' => $request->nombre,
                'nroPiezas' => $request->nroPiezas,
                'cantidad' => $request->cantidad,
                'descripcion' => $request->descripcion,
                'img_path' => $name,
                'color' => $request->color,
                'edad_min' => $request->edad_min,
                'edad_max' => $request->edad_max,
                'precio' => $request->precio,
                'genero' => $request->genero,
            ]);
            $disfraz->save();

            //disfraz-categorias
            $conjuntos = $request->get('conjuntos');
            $categorias = $request->get('categorias');
            $disfraz->conjuntos()->attach($conjuntos);
            $disfraz->categorias()->attach($categorias);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error al crear disfraz: ' . $e->getMessage());
            return redirect()->route('disfrazs.index')->with('error', 'Error al registrar disfraz');
        }
        return redirect()->route('disfrazs.index')->with('success', 'Disfraz registrado');*/
        dd($request);
    }


    public function show(string $id)
    {
        //
    }


    public function edit(Disfraz $disfraz)
    {
        // Obtener todas las categorías activas
        $categorias = Categoria::where('estado', 1)->get();
        return view('disfraz.edit', compact('disfraz', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDisfrazRequest $request, Disfraz $disfraz)
    {
        try {
            DB::beginTransaction();
            if ($request->hasFile('img_path')) {
                $name = $disfraz->hanbleUploadImage($request->file('img_path'));

                //Eliminar imagen

                if (Storage::disk('public')->exists('disfrazs/' . $disfraz->img_path)) {
                    Storage::disk('public')->delete('disfrazs/' . $disfraz->img_path);
                }
            } else {
                $name = $disfraz->img_path;
            }
            $disfraz->fill([
                'nombre' => $request->nombre,
                'nroPiezas' => $request->nroPiezas,
                'cantidad' => $request->cantidad,
                'descripcion' => $request->descripcion,
                'img_path' => $name,
                'color' => $request->color,
                'edad_min' => $request->edad_min,
                'edad_max' => $request->edad_max,
                'precio' => $request->precio,
                'genero' => $request->genero,
            ]);
            $disfraz->save();

            //disfraz-categorias
            $categorias = $request->get('categorias');
            $disfraz->categorias()->sync($categorias);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('disfrazs.index')->with('success', 'Disfraz editado');
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
    public function mostrarPiezas(Request $request)
    {
        $conjuntoId = $request->input('conjunto_id');
        $piezas = Pieza::where('conjunto_id', $conjuntoId)->get();

        return view('tu_vista', compact('piezas'));
    }
}
