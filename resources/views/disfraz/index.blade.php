@extends('template')

@section('title', 'Disfrazs')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endpush

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: "{{ session('success') }}",
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Disfraces</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Disfraces</li>
        </ol>
        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formDisfrazModal">
                Añadir nuevo registro
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="formDisfrazModal" tabindex="-1" aria-labelledby="formDisfrazModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formDisfrazModalLabel">Registrar Nuevo Disfraz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('disfraz.create')
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Disfraces
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disfrazs as $item)
                            <tr>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>
                                    @if ($item->estado == 1)
                                        <span class="fw-bold p-1 rounded bg-success text-white">Activo</span>
                                    @else
                                        <span class="fw-bold p-1 rounded bg-danger text-white">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <form action="{{ route('disfrazs.edit', ['disfraz' => $item]) }}">
                                            <button type="submit" class="btn btn-warning">Editar</button>
                                        </form>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#verModal-{{ $item->id }}">Ver</button>
                                        @if ($item->estado == 1)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $item->id }}">Eliminar</button>
                                        @else
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $item->id }}">Restaurar</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal Detalle -->
                            <div class="modal fade" id="verModal-{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detalles del Disfraz</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>N° de Piezas:</strong> {{ $item->nroPiezas }}</p>
                                            <p><strong>Cantidad:</strong> {{ $item->cantidad }}</p>
                                            <p><strong>Color:</strong> {{ $item->color }}</p>
                                            <p><strong>Rango de Edad:</strong> {{ $item->edad_min }}-{{ $item->edad_max }}
                                            </p>
                                            <p><strong>Género:</strong> {{ $item->genero }}</p>
                                            <p><strong>Categorías:</strong>
                                                @foreach ($item->categorias as $category)
                                                    <span class="badge bg-secondary">{{ $category->nombre }}</span>
                                                @endforeach
                                            </p>
                                            <p><strong>Precio:</strong> {{ $item->precio }} Bs.</p>
                                            <p>
                                                <strong>Imagen:</strong>
                                                @if ($item->img_path)
                                                    <img src="{{ Storage::url('public/disfrazs/' . $item->img_path) }}"
                                                        alt="{{ $item->nombre }}" class="img-fluid rounded border">
                                                @else
                                                    <span>No disponible</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Confirmación -->
                            <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $item->estado == 1 ? '¿Estás seguro de que deseas eliminar este disfraz?' : '¿Estás seguro de que deseas restaurar este disfraz?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('disfrazs.destroy', ['disfraz' => $item->id]) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Confirmar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('formDisfrazModal');
            modal.addEventListener('shown.bs.modal', () => {
                $('.selectpicker').selectpicker('render');
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let currentStep = 1;

            // Validar un campo individual
            function validateField(field) {
                if (field.value.trim() === "" || (field.type === "number" && field.value < 1)) {
                    field.classList.add("is-invalid"); // Campo inválido
                    field.classList.remove("is-valid");
                    return false;
                } else {
                    field.classList.add("is-valid"); // Campo válido
                    field.classList.remove("is-invalid");
                    return true;
                }
            }

            // Validar todos los campos de un paso específico
            function validateStep(step) {
                let isValid = true;
                const stepFields = document.querySelectorAll(`#step-${step} input, #step-${step} select`);
                stepFields.forEach((field) => {
                    if (!validateField(field)) isValid = false;
                });

                // Validación adicional para el Paso 2 (Piezas)
                if (step === 2) {
                    const piezaRows = document.querySelectorAll('#piezas-container .row');
                    if (piezaRows.length === 0) {
                        isValid = false;
                        Swal.fire({
                            icon: "error",
                            title: "¡Revisa los campos!",
                            text: "Debes agregar al menos una pieza antes de continuar.",
                        });
                    }
                }
                return isValid;
            }

            // Validar en tiempo real
            const inputs = document.querySelectorAll("input, select");
            inputs.forEach((input) => {
                input.addEventListener("input", () => validateField(input));
            });

            // Navegación entre pasos
            window.nextStep = (step) => {
                if (validateStep(currentStep)) {
                    document.getElementById(`step-${currentStep}`).classList.add("d-none");
                    document.getElementById(`step-${step}`).classList.remove("d-none");
                    currentStep = step;
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "¡Revisa los campos!",
                        text: "Asegúrate de llenar todos los campos requeridos.",
                    });
                }
            };

            window.prevStep = (step) => {
                document.getElementById(`step-${currentStep}`).classList.add("d-none");
                document.getElementById(`step-${step}`).classList.remove("d-none");
                currentStep = step;
            };
        });
    </script>

    <script>
        function fillConfirmation() {
            // Información General
            document.getElementById('confirm-nombre').innerText = document.getElementById('nombre').value;
            document.getElementById('confirm-genero').innerText = document.getElementById('genero').value;

            // Piezas Seleccionadas
            const piezasContainer = document.getElementById('confirm-piezas');
            piezasContainer.innerHTML = ''; // Limpiar
            document.querySelectorAll('#piezas-container .row').forEach(row => {
                const pieza = row.querySelector('select[name="piezas[]"]').selectedOptions[0].text;
                const cantidad = row.querySelector('input[name="cantidad[]"]').value;
                const color = row.querySelector('input[name="color[]"]').value || 'N/A';
                const talla = row.querySelector('input[name="talla[]"]').value || 'N/A';
                piezasContainer.innerHTML +=
                    `<li>${pieza} - Cantidad: ${cantidad}, Color: ${color}, Talla: ${talla}</li>`;
            });

            // Configuración
            const categorias = Array.from(document.getElementById('categorias').selectedOptions)
                .map(option => option.text).join(', ');
            document.getElementById('confirm-categorias').innerText = categorias;
            document.getElementById('confirm-precio').innerText = document.getElementById('precio').value;

            // Imagen
            const imgPath = document.getElementById('img_path');
            const previewContainer = document.getElementById('confirm-imagen');
            previewContainer.innerHTML = '';
            if (imgPath.files && imgPath.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded border">`;
                };
                reader.readAsDataURL(imgPath.files[0]);
            }
        }
    </script>
@endpush
