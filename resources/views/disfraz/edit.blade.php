@extends('template')

@section('title', 'Editar disfraz')

@push('css')
    <style>
        #descripcion {
            resize: none;
        }
    </style>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar Disfraces</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('disfrazs.index') }}">Disfraces</a></li>
            <li class="breadcrumb-item active">Editar disfraz</li>
        </ol>
        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('disfrazs.update', ['disfraz' => $disfraz]) }}" method="post"
                enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="row g-3">
                    <div class="col-md-6 mb-2">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre', $disfraz->nombre) }}">
                        @error('nombre')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="nroPiezas" class="form-label">N° de Piezas:</label>
                        <input type="text" name="nroPiezas" id="nroPiezas" class="form-control"
                            value="{{ old('nroPiezas', $disfraz->nroPiezas) }}">
                        @error('nroPiezas')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="cantidad" class="form-label">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control"
                            value="{{ old('cantidad', $disfraz->cantidad) }}">
                        @error('cantidad')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripcion:</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ old('descripcion', $disfraz->descripcion) }}</textarea>
                        @error('descripcion')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="img_path" class="form-label">Imagen:</label>
                        <input type="file" name="img_path" id="img_path" class="form-control" accept="Image/*">
                        @error('img_path')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="color" class="form-label">Color:</label>
                        <input type="text" name="color" id="color" class="form-control"
                            value="{{ old('color', $disfraz->color) }}">
                        @error('color')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="edad_min" class="form-label">Edad Mínima:</label>
                        <input type="number" name="edad_min" id="edad_min" class="form-control"
                            value="{{ old('edad_min', $disfraz->edad_min) }}">
                        @error('edad_min')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="edad_max" class="form-label">Edad Máxima:</label>
                        <input type="number" name="edad_max" id="edad_max" class="form-control"
                            value="{{ old('edad_max', $disfraz->edad_max) }}">
                        @error('edad_max')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" name="precio" id="precio" class="form-control"
                            value="{{ old('precio', $disfraz->precio) }}">
                        @error('precio')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="genero" class="form-label">Genero:</label>
                        <select title="Seleccione el género" name="genero" id="genero"
                            class="form-control selectpicker">
                            <option value="masculino"
                                {{ old('genero', $disfraz->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino"
                                {{ old('genero', $disfraz->genero) == 'femenino' ? 'selected' : '' }}>
                                Femenino</option>
                            <option value="unisex" {{ old('genero', $disfraz->genero) == 'unisex' ? 'selected' : '' }}>
                                Unisex</option>
                        </select>
                        @error('genero')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 -md-2">
                        <label for="categorias" class="form-label">Categorias:</label>
                        <select data-size="4" title="seleccione las categorias" data-live-search="true"
                            name="categorias[]" id="categorias" class="form-control selectpicker show-tick" multiple>
                            @foreach ($categorias as $item)
                                @if (in_array($item->id, $disfraz->categorias->pluck('id')->toArray()))
                                    <option selected value="{{ $item->id }}"
                                        {{ in_array($item->id, old('categorias', [])) ? 'selected' : '' }}>
                                        {{ $item->nombre }}
                                    </option>
                                @else
                                @endif
                            @endforeach
                        </select>
                        @error('categorias')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <!--boton-->
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
