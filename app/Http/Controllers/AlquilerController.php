<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlquilerRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreClienteRequest;
use App\Models\Alquiler;
use App\Models\Cliente;
use App\Models\Disfraz;
use Exception;
use Illuminate\Http\Request;

class AlquilerController extends Controller
{
    public function index()
    {
        $alquilers = Alquiler::with(['alquilers'])->latest()->get();
        return view('alquiler.index', compact('alquilers'));
    }
    public function create()
    {
        $disfrazs = Disfraz::all();
        $clientes = Cliente::all();
        return view('alquiler.create', compact('disfrazs', 'clientes'));
    }
    public function store(StoreAlquilerRequest $request)
    {
        //
    }
}
