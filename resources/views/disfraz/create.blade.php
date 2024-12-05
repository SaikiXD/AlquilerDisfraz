@extends('template')

@section('title', 'crear disfraz')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@push('css')
    <style>
        #descripcion {
            resize: none;
        }
    </style>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Disfraces</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('disfrazs.index') }}">Disfraces</a></li>
            <li class="breadcrumb-item active">crear disfraz</li>
        </ol>
        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form id="multiStepForm" action="{{ route('disfrazs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Paso 1 -->
                <div class="form-step active" id="step1">
                    <h3>Paso 1</h3>
                    <div class="row g-6">
                        <div class="col-md-6 mb-2">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                value="{{ old('nombre') }}">
                            @error('nombre')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="genero" class="form-label">Genero:</label>
                            <select title="Seleccione el género" name="genero" id="genero"
                                class="form-control selectpicker">
                                <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>
                                    Masculino
                                </option>
                                <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>
                                    Femenino
                                </option>
                                <option value="unisex" {{ old('genero') == 'unisex' ? 'selected' : '' }}>Unisex
                                </option>
                            </select>
                            @error('genero')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label">Descripcion:</label>
                            <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="mt-3 text-center">
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                        </div>
                    </div>
                </div>
                <!-- Paso 2 -->
                <div class="form-step" id="step2">
                    <div class="row g-3">
                        <h3>Paso 2</h3>
                        <div class="col-md-6">
                            <label for="tipo_id" class="form-label">Tipos:</label>
                            <select name="tipo_id" id="tipo_id" class="form-control selectpicker"
                                title="Seleccione un tipo">
                                <option value="">Seleccione un tipo</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id }}"
                                        {{ old('tipo_id') == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_id')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="pieza_id" class="form-label">Pieza:</label>
                            <select name="pieza_id" id="pieza_id" class="form-control" title="Seleccione una pieza">
                                <option value="">Seleccione una pieza</option>
                            </select>
                            @error('pieza_id')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1"
                                value="{{ old('cantidad') }}">
                            @error('cantidad')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="color" class="form-label">Color:</label>
                            <input type="text" name="color" id="color" class="form-control"
                                value="{{ old('color') }}">
                            @error('color')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="talla" class="form-label">Talla:</label>
                            <select name="talla" id="talla" class="form-control selectpicker"
                                title="Seleccione una talla">
                                <option value="XXL" {{ old('talla') == 'XXL' ? 'selected' : '' }}>XXL</option>
                                <option value="XL" {{ old('talla') == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="L" {{ old('talla') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="M" {{ old('talla') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="S" {{ old('talla') == 'S' ? 'selected' : '' }}>S</option>
                                <option value="XS" {{ old('talla') == 'XS' ? 'selected' : '' }}>XS</option>
                            </select>
                            @error('talla')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="material" class="form-label">Material:</label>
                            <input type="text" name="material" id="material" class="form-control"
                                value="{{ old('material') }}">
                            @error('material')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="col-12 text-end mt-2">
                            <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
                        </div>
                        <!-- Tabla -->
                        <div class="col-12 mt-3">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo</th>
                                            <th>Pieza</th>
                                            <th>Cantidad</th>
                                            <th>Color</th>
                                            <th>Talla</th>
                                            <th>Material</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (old('arrayidpieza', []) as $index => $piezaId)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <input type="hidden" name="arrayidtipo[]"
                                                        value="{{ old('arrayidtipo')[$index] }}">
                                                    {{ $tipos->find(old('arrayidtipo')[$index])->nombre ?? '' }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="arrayidpieza[]"
                                                        value="{{ $piezaId }}">
                                                    {{ $piezas->find($piezaId)->nombre ?? '' }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="arraycantidad[]"
                                                        value="{{ old('arraycantidad')[$index] }}">
                                                    {{ old('arraycantidad')[$index] }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="arraycolor[]"
                                                        value="{{ old('arraycolor')[$index] }}">
                                                    {{ old('arraycolor')[$index] }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="arraytalla[]"
                                                        value="{{ old('arraytalla')[$index] }}">
                                                    {{ old('arraytalla')[$index] }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="arraymaterial[]"
                                                        value="{{ old('arraymaterial')[$index] }}">
                                                    {{ old('arraymaterial')[$index] }}
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-row">Eliminar</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Botones -->
                        <div class="col-12 mt-3 text-center">
                            <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                        </div>
                    </div>
                </div>
                <!-- Paso 3 -->
                <div class="form-step" id="step3">
                    <h3>Paso 3</h3>
                    <div class="col-md-6 mb-2">
                        <label for="img_path" class="form-label">Imagen:</label>
                        <input type="file" name="img_path" id="img_path" class="form-control" accept="Image/*">
                        @error('img_path')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" name="precio" id="precio" class="form-control"
                            value="{{ old('precio') }}">
                        @error('precio')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 -md-2">
                        <label for="categorias" class="form-label">Categorias:</label>
                        <select data-size="4" title="seleccione las categorias" data-live-search="true"
                            name="categorias[]" id="categorias" class="form-control selectpicker show-tick" multiple>
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
                    <!--boton-->
                    <button type="button" class="btn btn-secondary prev-step">Anterior</button>
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
    <script>
        $(document).ready(function() {
            // Manejo del cambio en tipo_id
            $('#tipo_id').on('change', function() {
                const tipoId = $(this).val();
                $('#pieza_id').empty().append('<option value="">Seleccione una pieza</option>');
                if (tipoId) {
                    $.ajax({
                        url: '/disfraz/piezas',
                        type: 'POST',
                        data: {
                            tipo_id: tipoId,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            if (Array.isArray(response)) {
                                response.forEach(pieza => {
                                    $('#pieza_id').append(
                                        `<option value="${pieza.id}">${pieza.nombre}</option>`
                                    );
                                });
                            } else {
                                alert('Error al cargar las piezas.');
                            }
                        },
                        error: function() {
                            alert('Error al cargar las piezas. Intente nuevamente.');
                        },
                    });
                }
            });
            // Agregar productos a la tabla
            $('#btn_agregar').on('click', function() {
                const tipo = $('#tipo_id option:selected').text();
                const tipoId = $('#tipo_id').val();
                const pieza = $('#pieza_id option:selected').text();
                const piezaId = $('#pieza_id').val();
                const cantidad = $('#cantidad').val();
                const color = $('#color').val();
                const talla = $('#talla').val();
                const material = $('#material').val();

                if (!tipoId || !piezaId || !cantidad || !color || !talla || !material) {
                    alert('Complete todos los campos antes de agregar.');
                    return;
                }

                const fila = `
<tr>
    <td>${$('#tabla_detalle tbody tr').length + 1}</td>
    <td><input type="hidden" name="arrayidtipo[]" value="${tipoId}">${tipo}</td>
    <td><input type="hidden" name="arrayidpieza[]" value="${piezaId}">${pieza}</td>
    <td><input type="hidden" name="arraycantidad[]" value="${cantidad}">${cantidad}</td>
    <td><input type="hidden" name="arraycolor[]" value="${color}">${color}</td>
    <td><input type="hidden" name="arraytalla[]" value="${talla}">${talla}</td>
    <td><input type="hidden" name="arraymaterial[]" value="${material}">${material}</td>
    <td><button type="button" class="btn btn-danger btn-sm remove-row">Eliminar</button></td>
</tr>`;
                $('#tabla_detalle tbody').append(fila);

                // Limpiar campos
                $('#tipo_id').val('').selectpicker('val', '').selectpicker('render');
                $('#pieza_id').empty().append('<option value="">Seleccione una pieza</option>');
                $('#cantidad').val('');
                $('#color').val('');
                $('#talla').val('');
                $('#material').val('');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let currentStep = 0;
            const steps = $(".form-step");

            $(".next-step").on("click", function() {
                if (currentStep < steps.length - 1) {
                    $(steps[currentStep]).removeClass("active");
                    currentStep++;
                    $(steps[currentStep]).addClass("active");
                }
            });

            $(".prev-step").on("click", function() {
                if (currentStep > 0) {
                    $(steps[currentStep]).removeClass("active");
                    currentStep--;
                    $(steps[currentStep]).addClass("active");
                }
            });
        });
    </script>
    <style>
        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }
    </style>
@endpush
