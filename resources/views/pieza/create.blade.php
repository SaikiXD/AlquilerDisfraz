@extends('template')

@section('title', 'crear pieza')

@push('css')
    <style>
        #descripcion {
            resize: none;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Pieza</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('piezas.index') }}">Pieza</a></li>
            <li class="breadcrumb-item active">crear pieza</li>
        </ol>
        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('piezas.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre') }}">
                        @error('nombre')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_id" class="form-label">Tipo:</label>
                        <select data-size="4" title="Seleccione una tipo" data-live-search="true" name="tipo_id"
                            id="tipo_id" class="form-control selectpicker show-tick">
                            @foreach ($tipos as $item)
                                <option value="{{ $item->id }}" {{ old('tipo_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush
