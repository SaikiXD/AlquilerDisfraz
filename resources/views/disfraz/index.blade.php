@extends('template')

@section('title', 'Disfrazs')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    @if (session('success'))
        <script>
            let message = "{{ session('success') }}";
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: message
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
            <a href="{{ route('disfrazs.create') }}">
                <button type="button" class="btn btn-primary">Añadir nuevo registro</button>
            </a>
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
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disfrazs as $item)
                            <tr>
                                <td>
                                    {{ $item->nombre }}
                                </td>
                                <td>
                                    {{ $item->descripcion }}
                                </td>
                                <td>
                                    @if ($item->estado == 1)
                                        <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                                    @else
                                        <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
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
                            <!-- Modal -->
                            <div class="modal fade" id="verModal-{{ $item->id }}" tabindex="-1"
                                aria-labelledby="modalLabel-{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Header -->
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="modalLabel-{{ $item->id }}">Detalles del
                                                Disfraz: {{ $item->nombre }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <!-- Body -->
                                        <div class="modal-body">
                                            <!-- Imagen -->
                                            <!-- Imagen -->
                                            <div class="text-center mb-4">
                                                @if ($item->img_path && Storage::disk('public')->exists($item->img_path))
                                                    <img src="{{ asset('storage/' . $item->img_path) }}"
                                                        alt="{{ $item->nombre }}"
                                                        class="img-fluid rounded shadow-sm mx-auto d-block"
                                                        style="max-width: 300px; max-height: 200px; object-fit: cover;"
                                                        loading="lazy">
                                                @else
                                                    <p class="text-muted">No hay imagen disponible.</p>
                                                @endif
                                            </div>
                                            <!-- Información del disfraz -->
                                            <div class="mb-3">
                                                <h6 class="fw-bold">Nombre:</h6>
                                                <p>{{ $item->nombre }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="fw-bold">Descripción:</h6>
                                                <p>{{ $item->descripcion }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="fw-bold">Género:</h6>
                                                <p>{{ ucfirst($item->genero) }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="fw-bold">Precio:</h6>
                                                <p>{{ $item->precio }} Bs.</p>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="fw-bold">Estado:</h6>
                                                <p>
                                                    @if ($item->estado == 1)
                                                        <span class="badge bg-success">Activo</span>
                                                    @else
                                                        <span class="badge bg-danger">Eliminado</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <!-- Categorías -->
                                            <div class="mb-3">
                                                <h6 class="fw-bold">Categorías:</h6>
                                                @if ($item->categorias->isNotEmpty())
                                                    @foreach ($item->categorias as $category)
                                                        <span class="badge me-1"
                                                            style="background-color: {{ $category->color ?? '#6c757d' }};">
                                                            {{ $category->nombre }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <p class="text-muted">Sin categorías.</p>
                                                @endif
                                            </div>
                                            <!-- Piezas -->
                                            <div class="accordion mb-3" id="piezasAccordion-{{ $item->id }}">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingPiezas-{{ $item->id }}">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapsePiezas-{{ $item->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapsePiezas-{{ $item->id }}">
                                                            Piezas
                                                        </button>
                                                    </h2>
                                                    <div id="collapsePiezas-{{ $item->id }}"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="headingPiezas-{{ $item->id }}"
                                                        data-bs-parent="#piezasAccordion-{{ $item->id }}">
                                                        <div class="accordion-body">
                                                            @if ($item->piezas->isNotEmpty())
                                                                <ul class="list-group list-group-flush">
                                                                    @foreach ($item->piezas as $pieza)
                                                                        <li class="list-group-item">
                                                                            <strong>{{ $pieza->nombre }}</strong><br>
                                                                            Tipo: {{ $pieza->tipo->nombre }}<br>
                                                                            Cantidad: {{ $pieza->pivot->cantidad }}<br>
                                                                            Color: {{ $pieza->pivot->color }}<br>
                                                                            Talla: {{ $pieza->pivot->talla }}<br>
                                                                            Material: {{ $pieza->pivot->material }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p class="text-muted">No hay piezas asociadas a este
                                                                    disfraz.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $item->estado == 1 ? '¿Seguro quieres eliminar el disfraz?' : '¿Seguro quieres restaurar el disfraz?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <form action="{{ route('disfrazs.destroy', ['disfraz' => $item->id]) }}"
                                                method="post">
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
