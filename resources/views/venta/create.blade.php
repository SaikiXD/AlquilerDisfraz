@extends('template')

@section('title', 'Crear Disfraz')

@push('css')
    <style>
        #descripcion {
            resize: none;
        }
    </style>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Disfraz</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('disfrazs.index') }}">Disfraces</a></li>
            <li class="breadcrumb-item active">Crear Disfraz</li>
        </ol>
        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('disfrazs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-md-6 mb-2">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre') }}">
                        @error('nombre')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!-- Número de Piezas -->
                    <div class="col-md-3 mb-2">
                        <label for="nroPiezas" class="form-label">N° de Piezas:</label>
                        <input type="text" name="nroPiezas" id="nroPiezas" class="form-control"
                            value="{{ old('nroPiezas') }}">
                        @error('nroPiezas')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!-- Cantidad -->
                    <div class="col-md-3">
                        <label for="cantidad" class="form-label">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control"
                            value="{{ old('cantidad') }}">
                        @error('cantidad')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!-- Descripción -->
                    <div class="col-md-12">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!-- Imagen -->
                    <div class="col-md-6 mb-2">
                        <label for="img_path" class="form-label">Imagen:</label>
                        <input type="file" name="img_path" id="img_path" class="form-control" accept="image/*">
                        @error('img_path')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!-- Color -->
                    <div class="col-md-2">
                        <label for="color" class="form-label">Color:</label>
                        <input type="text" name="color" id="color" class="form-control"
                            value="{{ old('color') }}">
                        @error('color')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!-- Precio -->
                    <div class="col-md-2">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" name="precio" id="precio" class="form-control"
                            value="{{ old('precio') }}">
                        @error('precio')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!-- Género -->
                    <div class="col-md-4">
                        <label for="genero" class="form-label">Género:</label>
                        <select title="Seleccione el género" name="genero" id="genero"
                            class="form-control selectpicker">
                            <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino
                            </option>
                            <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="unisex" {{ old('genero') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                        </select>
                        @error('genero')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!-- Categorías -->
                    <div class="col-md-6">
                        <label for="categorias" class="form-label">Categorías:</label>
                        <select data-live-search="true" title="Seleccione las categorías" name="categorias[]"
                            id="categorias" class="form-control selectpicker show-tick" multiple>
                            @foreach ($categorias as $item)
                                <option value="{{ $item->id }}"
                                    {{ in_array($item->id, old('categorias', [])) ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorias')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!-- Botones -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="reset" class="btn btn-secondary">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('.selectpicker').selectpicker('render');
        });
    </script>
@endpush
