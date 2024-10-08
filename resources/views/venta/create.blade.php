@extends('template')

@section('title', 'Realizar alquiler')

@push('css')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Realizar Alquiler</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Alquileres</a></li>
            <li class="breadcrumb-item active">Realizar Alquiler</li>
        </ol>
    </div>
    <form action="{{ route('ventas.store') }}" method="post">
        @csrf

        <div class="container-lg mt-4">
            <div class="row gy-4">
                <!------alquiler disfraz---->
                <div class="col-xl-8">
                    <div class="text-white bg-primary p-1 text-center">
                        Detalles del alquiler
                    </div>
                    <div class="p-3 border border-3 border-primary">
                        <div class="row">
                            <!-----disfraz---->
                            <div class="col-12 mb-4">
                                <select name="disfraz_id" id="disfraz_id" class="form-control selectpicker"
                                    data-live-search="true" data-size="1" title="Busque un disfraz aquí">
                                    @foreach ($disfrazs as $item)
                                        <option value="{{ $item->id }}-{{ $item->cantidad }}-{{ $item->precio }}">
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-----Stock--->
                            <div class="d-flex justify-content-end mb-4">
                                <div class="col-12 col-sm-6">
                                    <div class="row">
                                        <label for="stock" class="col-form-label col-sm-4">Stock:</label>
                                        <div class="col-sm-8">
                                            <input disabled id="stock" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-----Cantidad---->
                            <div class="col-sm-4 mb-2">
                                <label for="cantidad" class="form-label">Cantidad:</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control">
                            </div>

                            <!-----Precio de venta---->
                            <div class="col-sm-4 mb-2">
                                <label for="precio_venta" class="form-label">Precio de venta:</label>
                                <div class="input-group">
                                    <span class="input-group-text">BS</span>
                                    <input disabled type="number" name="precio_venta" id="precio_venta"
                                        class="form-control" step="0.1">
                                </div>
                            </div>


                            <!-----botón para agregar--->
                            <div class="col-12 mb-4 mt-2 text-end">
                                <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
                            </div>

                            <!-----Tabla para el detalle de la Venta--->
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="tabla_detalle" class="table table-hover">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="text-white">#</th>
                                                <th class="text-white">Disfraz</th>
                                                <th class="text-white">Cantidad</th>
                                                <th class="text-white">Precio venta</th>
                                                <th class="text-white">Subtotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th></th>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th colspan="3">Sumas</th>
                                                <th colspan="2"><span id="sumas">0</span></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="3">Garantia</th>
                                                <th colspan="2"><span id="garantia">0</span></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="3">Total</th>
                                                <th colspan="2"> <input type="hidden" name="total" value="0"
                                                        id="inputTotal"> <span id="total">0</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!--Boton para cancelar venta-->
                            <div class="col-12 mt-2">
                                <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Cancelar venta
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-----venta---->
                <div class="col-xl-4">
                    <div class="text-white bg-success p-1 text-center">
                        Datos generales
                    </div>
                    <div class="p-3 border border-3 border-success">
                        <div class="row">
                            <!--Cliente-->
                            <div class="col-12 mb-2">
                                <label for="cliente_id" class="form-label">Cliente:</label>
                                <select name="cliente_id" id="cliente_id" class="form-control selectpicker show-tick"
                                    data-live-search="true" title="Selecciona" data-size='2'>
                                    @foreach ($clientes as $item)
                                        <option value="{{ $item->id }}">{{ $item->persona->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            <!--garantia-->
                            <div class="col-12 mb-2">
                                <label for="garantia_id" class="form-label">Tipo Garantia:</label>
                                <select name="garantia_id" id="garantia_id" class="form-control selectpicker show-tick"
                                    title="Selecciona">
                                    @foreach ($garantias as $item)
                                        <option value="{{ $item->id }}">{{ $item->tipo_garantia }}</option>
                                    @endforeach
                                </select>
                                @error('garantia_id')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>
                            <!--imagen de la Garantía -->
                            <div class="col-md-6 mb-2" id="imagen_garantia_container" style="display: none;">
                                <label for="img_path" class="form-label">Imagen:</label>
                                <input type="file" name="img_path" id="img_path" class="form-control"
                                    accept="Image/*">
                                @error('img_path')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>
                            <!-- Descripción de la Garantía -->
                            <div class="col-md-12 mb-2" id="descripcion_garantia_container" style="display: none;">
                                <label for="descripcion_garantia" class="form-label">Descripción de la Garantía:</label>
                                <input type="text" name="descripcion_garantia" id="descripcion_garantia"
                                    class="form-control">
                                @error('descripcion_garantia')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            <!-- Valor de la Garantía -->
                            <div class="col-md-12 mb-2" id="valor_garantia_container" style="display: none;">
                                <label for="valor_garantia" class="form-label">Valor de la Garantía:</label>
                                <div class="input-group">
                                    <span class="input-group-text">BS</span>
                                    <input type="text" name="valor_garantia" id="valor_garantia" class="form-control"
                                        default='0'>
                                </div>
                                @error('valor_garantia')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>
                            <!--Garantia---->
                            <div class="col-sm-6">
                                <label for="garantia_container" class="form-label">Garantia(BS):</label>
                                <input readonly type="text" name="garantia_container" id="garantia_container"
                                    class="form-control border-success">
                                @error('garantia_container')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>
                            <!-- Fecha Alquiler -->
                            <div class="col-sm-6 mb-2">
                                <label for="fecha_alquiler" class="form-label">Fecha Alquiler:</label>
                                <input type="date" name="fecha_alquiler" id="fecha_alquiler"
                                    class="form-control border-success" value="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <!-- Fecha de Devolución -->
                            <div class="col-sm-6 mb-2">
                                <label for="fecha_devolucion" class="form-label">Fecha Devolución:</label>
                                <input type="date" name="fecha_devolucion" id="fecha_devolucion"
                                    class="form-control border-success">
                            </div>


                            <!--User--->
                            <input type="hidden" name="user_id" value="1">
                            <!--Botones--->
                            <div class="col-12 mt-4 text-center">
                                <button type="submit" class="btn btn-success" id="guardar">Realizar Venta</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para cancelar la venta -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Advertencia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que quieres cancelar la venta?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button id="btnCancelarVenta" type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#disfraz_id').change(mostrarValores);


            $('#btn_agregar').click(function() {
                agregarDisfraz();
            });

            $('#btnCancelarVenta').click(function() {
                cancelarVenta();
            });

            disableButtons();
        });

        $(document).ready(function() {
            $('#garantia_id').change(function() {
                const garantiaId = $(this).val();

                // Manejar visibilidad de los campos
                switch (garantiaId) {
                    case '1':
                        $('#imagen_garantia_container').hide();
                        $('#descripcion_garantia_container').hide();
                        $('#valor_garantia_container').hide();
                        break;
                    case '2':
                        $('#imagen_garantia_container').show();
                        $('#descripcion_garantia_container').show();
                        $('#valor_garantia_container').show();
                        break;
                    default:
                        $('#imagen_garantia_container').hide();
                        $('#descripcion_garantia_container').hide();
                        $('#valor_garantia_container').hide();
                        break;
                }
            });

            // Inicializar el estado al cargar la página
            $('#garantia_id').trigger('change');
        });

        //Variables
        let cont = 0;
        let subtotal = [];
        let sumas = 0;
        let garantia = 0;
        let total = 0;

        function mostrarValores() {
            let dataDisfraz = document.getElementById('disfraz_id').value.split('-');
            $('#stock').val(dataDisfraz[1]);
            $('#precio_venta').val(dataDisfraz[2]);
        }

        function agregarDisfraz() {
            let dataDisfraz = document.getElementById('disfraz_id').value.split('-');
            //Obtener valores de los campos
            let idDisfraz = dataDisfraz[0];
            let nameDisfraz = $('#disfraz_id option:selected').text();
            let cantidad = $('#cantidad').val();
            let precioVenta = $('#precio_venta').val();
            let stock = $('#stock').val();
            //Validaciones 
            //1.Para que los campos no esten vacíos
            if (idDisfraz != '' && cantidad != '') {

                //2. Para que los valores ingresados sean los correctos
                if (parseInt(cantidad) > 0 && (cantidad % 1 == 0)) {

                    //3. Para que la cantidad no supere el stock
                    if (parseInt(cantidad) <= parseInt(stock)) {
                        //Calcular valores
                        subtotal[cont] = round(cantidad * precioVenta);
                        sumas += subtotal[cont];
                        garantia = sumas;
                        total = round(sumas + garantia);

                        //Crear la fila
                        let fila = '<tr id="fila' + cont + '">' +
                            '<th>' + (cont + 1) + '</th>' +
                            '<td><input type="hidden" name="arrayiddisfraz[]" value="' + idDisfraz + '">' + nameDisfraz +
                            '</td>' +
                            '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad +
                            '</td>' +
                            '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' +
                            precioVenta + '</td>' +
                            '<td>' + subtotal[cont] + '</td>' +
                            '<td><button class="btn btn-danger" type="button" onClick="eliminarDisfraz(' + cont +
                            ')"><i class="fa-solid fa-trash"></i></button></td>' +
                            '</tr>';

                        //Acciones después de añadir la fila
                        $('#tabla_detalle').append(fila);
                        limpiarCampos();
                        cont++;
                        disableButtons();

                        //Mostrar los campos calculados
                        $('#sumas').html(sumas);
                        $('#garantia').html(garantia);
                        $('#total').html(total);
                        $('#garantia_container').val(garantia);
                        $('#inputTotal').val(total);
                    } else {
                        showModal('Cantidad incorrecta');
                    }

                } else {
                    showModal('Valores incorrectos');
                }

            } else {
                showModal('Le faltan campos por llenar');
            }

        }

        function eliminarDisfraz(indice) {
            //Calcular valores
            sumas -= round(subtotal[indice]);
            total = round(sumas);

            //Mostrar los campos calculados
            $('#sumas').html(sumas);
            $('#total').html(total);
            $('#InputTotal').val(total);

            //Eliminar el fila de la tabla
            $('#fila' + indice).remove();

            disableButtons();
        }

        function cancelarVenta() {
            //Elimar el tbody de la tabla
            $('#tabla_detalle tbody').empty();

            //Añadir una nueva fila a la tabla
            let fila = '<tr>' +
                '<th></th>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '</tr>';
            $('#tabla_detalle').append(fila);

            //Reiniciar valores de las variables
            cont = 0;
            subtotal = [];
            sumas = 0;
            total = 0;

            //Mostrar los campos calculados
            $('#sumas').html(sumas);
            $('#total').html(total);
            $('#inputTotal').val(total);

            limpiarCampos();
            disableButtons();
        }

        function limpiarCampos() {
            let select = $('#disfraz_id');
            select.selectpicker('val', '');
            $('#cantidad').val('');
            $('#precio_venta').val('');
            $('#stock').val('');
        }

        function disableButtons() {
            if (total == 0) {
                $('#guardar').hide();
                $('#cancelar').hide();
            } else {
                $('#guardar').show();
                $('#cancelar').show();
            }
        }

        function showModal(message, icon = 'error') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: icon,
                title: message
            })
        }

        function round(num, decimales = 2) {
            var signo = (num >= 0 ? 1 : -1);
            num = num * signo;
            if (decimales === 0) //con 0 decimales
                return signo * Math.round(num);
            // round(x * 10 ^ decimales)
            num = num.toString().split('e');
            num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
            // x * 10 ^ (-decimales)
            num = num.toString().split('e');
            return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
        }
        //Fuente: https://es.stackoverflow.com/questions/48958/redondear-a-dos-decimales-cuando-sea-necesario
    </script>
@endpush
