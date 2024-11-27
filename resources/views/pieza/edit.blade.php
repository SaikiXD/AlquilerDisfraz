@extends('template')

@section('title', 'Editar pieza')

@push('css')
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar pieza</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('piezas.index') }}">Pieza</a></li>
            <li class="breadcrumb-item active">Editar pieza</li>
        </ol>
        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('piezas.update', ['pieza' => $pieza]) }}" method="post">
                @method('PATCH')
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre', $pieza->nombre) }}">
                        @error('nombre')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="tipo" class="form-label">Tipo de pieza:</label>
                        <select title="Seleccione el tipo de pieza" name="tipo" id="tipo"
                            class="form-control selectpicker">
                            <option value="Prendas de vestir"
                                {{ old('tipo', $pieza->tipo) == 'Prendas de vestir' ? 'selected' : '' }}>
                                Prendas de vestir
                            </option>
                            <option value="Accesorios" {{ old('tipo', $pieza->tipo) == 'Accesorios' ? 'selected' : '' }}>
                                Accesorios
                            </option>
                            <option value="Elementos de fantasía"
                                {{ old('tipo', $pieza->tipo) == 'Elementos de fantasía' ? 'selected' : '' }}>
                                Elementos de fantasía
                            </option>
                            <option value="Armas y herramientas"
                                {{ old('tipo', $pieza->tipo) == 'Armas y herramientas' ? 'selected' : '' }}>
                                Armas y herramientas
                            </option>
                        </select>
                        @error('tipo')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="reset" class="btn btn-secondary">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
@endpush
