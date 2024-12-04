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
                        <!--Cliente-->
                        <div class="col-12">
                            <label for="cliente_id" class="form-label">Cliente:</label>
                            <select name="cliente_id" id="cliente_id" class="form-control selectpicker show-tick"
                                data-live-search="true" title="Selecciona" data-size='2'>
                                @foreach ($clientes as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cliente_id')
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
                    <h3>Paso 2: Selección de Disfraces</h3>
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label for="disfraz_id" class="form-label">Seleccionar Disfraz:</label>
                            <select name="disfraz_id" id="disfraz_id" class="form-control selectpicker"
                                data-live-search="true">
                                <option value="">Seleccione un disfraz</option>
                                @foreach ($disfrazs as $disfraz)
                                    <option value="{{ $disfraz->id }}">{{ $disfraz->nombre }} - {{ $disfraz->precio }} Bs.
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1"
                                value="1">
                        </div>
                        <div class="col-md-3 text-end mt-4">
                            <button type="button" id="btn_add_disfraz" class="btn btn-primary">Agregar</button>
                        </div>
                        <!-- Tabla de disfraces -->
                        <div class="col-12 mt-3">
                            <div class="table-responsive">
                                <table id="tabla_disfraces" class="table table-hover">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Filas dinámicas -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 text-end mt-3">
                            <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                        </div>
                    </div>
                </div>
                <!-- Paso 3 -->
                <div class="form-step" id="step3">
                    <h3>Paso 3</h3>
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
        // Lógica de pasos
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

            // Agregar disfraces
            $("#btn_add_disfraz").on("click", function() {
                const disfrazId = $("#disfraz_id").val();
                const disfrazNombre = $("#disfraz_id option:selected").text();
                const cantidad = $("#cantidad").val();
                const precio = parseFloat($("#disfraz_id option:selected").data("precio"));

                if (disfrazId && cantidad > 0) {
                    const total = cantidad * precio;
                    $("#tabla_disfraces tbody").append(`
                        <tr>
                            <td>${disfrazNombre}</td>
                            <td>${cantidad}</td>
                            <td>${precio}</td>
                            <td>${total}</td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-disfraz">Eliminar</button></td>
                        </tr>
                    `);
                }
            });

            // Eliminar disfraz de la tabla
            $(document).on("click", ".remove-disfraz", function() {
                $(this).closest("tr").remove();
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
