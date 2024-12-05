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
        <h1 class="mt-4 text-center">Crear Alquiler</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('alquilers.index') }}">Alquiler</a></li>
            <li class="breadcrumb-item active">crear Alquiler</li>
        </ol>
        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form id="multiStepForm" action="{{ route('alquilers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Paso 1 -->
                <div class="form-step active" id="step1">
                    <h3>Paso 1</h3>
                    <div class="row g-6">
                        <!--Cliente-->
                        <div class="col-md-6">
                            <label for="cliente_id" class="form-label">Cliente:</label>
                            <select name="cliente_id" id="cliente_id" class="form-control selectpicker"
                                data-live-search="true" title="Seleccione un cliente" data-size='2'>
                                @foreach ($clientes as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('cliente_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nombre }}</option>
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
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="disfraz_id" class="form-label">Seleccionar Disfraz:</label>
                            <!-- Modificar las opciones del select para incluir data-stock y data-precio -->
                            <select name="disfraz_id" id="disfraz_id" class="form-control selectpicker"
                                data-live-search="true" title="Seleccione un disfraz">
                                @foreach ($disfrazs as $disfraz)
                                    <option value="{{ $disfraz->id }}" data-stock="{{ $disfraz->cantidad_minima }}"
                                        data-precio="{{ $disfraz->precio }}">
                                        {{ $disfraz->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-----Stock--->
                        <div class="d-flex justify-content-end">
                            <div class="col-md-6">
                                <div class="col-12 col-sm-6">
                                    <div class="row">
                                        <label for="stock" class="col-form-label col-4">En Stock:</label>
                                        <div class="col-8">
                                            <input disabled id="stock" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-----Cantidad---->
                        <div class="col-sm-4">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>
                        <!-----Precio de venta---->
                        <div class="col-md-2">
                            <label for="precio" class="form-label">Precio:</label>
                            <input type="number" name="precio" id="precio" class="form-control"
                                value="{{ old('precio') }}">
                            @error('precio')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <div class="col-12 text-end">
                            <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
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
                                        @foreach (old('arraydisfraz', []) as $index => $disfrazId)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <input type="hidden" name="arraydisfraz[]"
                                                        value="{{ $disfrazId }}">
                                                    {{ $disfrazs->find($disfrazId)->nombre ?? '' }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="arraycantidad[]"
                                                        value="{{ old('arraycantidad')[$index] }}">
                                                    {{ old('arraycantidad')[$index] }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="arrayprecio[]"
                                                        value="{{ old('arrayprecio')[$index] }}">
                                                    {{ old('arrayprecio')[$index] }}
                                                </td>
                                                <td>
                                                    {{ old('arraycantidad')[$index] * old('arrayprecio')[$index] }}
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-row">Eliminar</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                <div class="card mt-4">
                                    <div class="card-body bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0"><strong></strong> <span id="totalDisfraces"
                                                    class="text-primary"></span></h5>
                                        </div>
                                        <div>
                                            <h5 class="mb-0"><strong></strong> <span id="totalPrecio"
                                                    class="text-success"></span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-end mt-3">
                            <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                        </div>
                    </div>
                </div>
                <!-- Paso 3 -->
                <!-- Paso 3 -->
                <div class="form-step" id="step3">
                    <h3>Paso 3: Información de Garantía</h3>
                    <div class="row g-3">
                        <!-- Tipo de Garantía -->
                        <div class="col-md-6">
                            <label for="tipo_garantia" class="form-label">Tipo de Garantía:</label>
                            <select name="tipo_garantia" id="tipo_garantia" class="form-control">
                                <option value="">Seleccione un tipo</option>
                                <option value="dinero">Dinero</option>
                                <option value="documento">Documento</option>
                                <option value="objeto">Objeto</option>
                            </select>
                            @error('tipo_garantia')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <!-- Imagen de la Garantía -->
                        <div class="col-md-6 mb-2">
                            <label for="img_path_garantia" class="form-label">Imagen:</label>
                            <input type="file" name="img_path_garantia" id="img_path_garantia" class="form-control"
                                accept="Image/*">
                            @error('img_path_garantia')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <!-- Descripción de Garantía -->
                        <div class="col-12">
                            <label for="descripcion_garantia" class="form-label">Descripción de la Garantía:</label>
                            <textarea name="descripcion_garantia" id="descripcion_garantia" class="form-control" rows="4"></textarea>
                            @error('descripcion_garantia')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <!-- Valor de la Garantía -->
                        <div class="col-md-4">
                            <label for="valor_garantia" class="form-label">Valor de la Garantía:</label>
                            <input type="number" name="valor_garantia" id="valor_garantia" class="form-control"
                                step="0.01">
                            @error('valor_garantia')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <!-- Fecha de Alquiler -->
                        <div class="col-md-4">
                            <label for="fecha_alquiler" class="form-label">Fecha de Alquiler:</label>
                            <input type="date" name="fecha_alquiler" id="fecha_alquiler" class="form-control"
                                value="<?php echo date('Y-m-d'); ?>">
                            @error('fecha_alquiler')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                        <!-- Fecha de Devolución -->
                        <div class="col-md-4">
                            <label for="fecha_devolucion" class="form-label">Fecha de Devolución:</label>
                            <input type="date" name="fecha_devolucion" id="fecha_devolucion" class="form-control">
                            @error('fecha_devolucion')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones de Navegación -->
                    <div class="col-12 text-end mt-3">
                        <button type="button" class="btn btn-secondary prev-step">Anterior</button>
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
        });
    </script>
    <script>
        $(document).ready(function() {
            let stockTemporal = {}; // Almacena el stock temporal para cada disfraz

            // Mostrar valores (cantidad mínima y precio) cuando se selecciona un disfraz
            $('#disfraz_id').change(function() {
                const selectedOption = $('#disfraz_id option:selected');
                const cantidad = selectedOption.data('stock');
                const precio = selectedOption.data('precio');
                const disfrazId = selectedOption.val();

                // Verificar si hay un stock temporal ya ajustado
                const stockDisponible = stockTemporal[disfrazId] !== undefined ? stockTemporal[disfrazId] :
                    cantidad;

                $('#stock').val(stockDisponible !== undefined ? stockDisponible : '');
                $('#precio').val(precio !== undefined ? precio : '');
            });

            // Calcular totales al inicializar o modificar la tabla
            function calcularTotales() {
                let totalCantidad = 0;
                let totalPrecio = 0;

                // Iterar sobre las filas para calcular los totales
                $('#tabla_disfraces tbody tr').each(function() {
                    const cantidad = parseInt($(this).find('td:eq(2)').text()) || 0;
                    const total = parseFloat($(this).find('td:eq(4)').text()) || 0;

                    totalCantidad += cantidad;
                    totalPrecio += total;
                });

                // Actualizar los valores en los elementos correspondientes
                $('#totalDisfraces').text(`Total disfraces: ${totalCantidad}`);
                $('#totalPrecio').text(`Total precio: Bs ${totalPrecio.toFixed(2)}`);
            }

            // Lógica para agregar filas en la tabla
            $("#btn_agregar").on("click", function() {
                const disfrazId = $("#disfraz_id").val();
                const disfrazNombre = $("#disfraz_id option:selected").text();
                const cantidad = parseInt($('#cantidad').val());
                const precio = parseFloat($("#precio").val());
                const stockDisponible = parseInt($('#stock').val());
                const total = cantidad * precio;

                if (!disfrazId || !cantidad || !precio) {
                    alert("Por favor, complete todos los campos antes de agregar un disfraz.");
                    return;
                }

                if (cantidad > stockDisponible) {
                    alert("La cantidad no puede superar el stock disponible.");
                    return;
                }

                // Crear la fila
                const fila = `
        <tr data-disfraz-id="${disfrazId}">
            <td>${$('#tabla_disfraces tbody tr').length + 1}</td>
            <td><input type="hidden" name="arraydisfraz[]" value="${disfrazId}">${disfrazNombre}</td>
            <td><input type="hidden" name="arraycantidad[]" value="${cantidad}">${cantidad}</td>
            <td><input type="hidden" name="arrayprecio[]" value="${precio}">${precio.toFixed(2)}</td>
            <td>${total.toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-disfraz">Eliminar</button></td>
        </tr>`;

                $('#tabla_disfraces tbody').append(fila);

                // Ajustar el stock temporal
                stockTemporal[disfrazId] = stockDisponible - cantidad;

                // Limpiar los campos
                $('#disfraz_id').val('').selectpicker('val', '').selectpicker('render');
                $('#cantidad').val('');
                $('#precio').val('');
                $('#stock').val('');

                // Recalcular totales
                calcularTotales();
            });

            // Eliminar una fila de la tabla y restaurar el stock temporal
            $(document).on("click", ".remove-disfraz", function() {
                const fila = $(this).closest("tr");
                const disfrazId = fila.data('disfraz-id');
                const cantidad = parseInt(fila.find('td:eq(2)').text());

                // Restaurar el stock temporal
                stockTemporal[disfrazId] = (stockTemporal[disfrazId] || 0) + cantidad;

                fila.remove();

                // Recalcular totales
                calcularTotales();
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
