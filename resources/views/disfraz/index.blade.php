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
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del Disfraz</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">N° de piezas:
                                                    </span>{{ $item->nroPiezas }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label for=""><span
                                                        class="fw-bolder">Cantidad:</span>{{ $item->cantidad }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Color:
                                                    </span>{{ $item->color }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Rango de edad:
                                                    </span>{{ $item->edad_min }}-{{ $item->edad_max }}</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Genero:
                                                    </span>{{ $item->genero }}</label>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="">
                                                    <span class="fw-bolder">Categorias: </span>
                                                    @foreach ($item->categorias as $category)
                                                        <span
                                                            class="m-1 rounded-pill p-1 bg-secondary text-white text-center">{{ $category->nombre }}
                                                        </span>
                                                    @endforeach
                                            </div>
                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Precio:
                                                    </span>{{ $item->precio }}Bs.</label>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="fw-bolder">Imagen:</label>
                                                <div>
                                                    @if ($item->img_path != null)
                                                        <img src="{{ Storage::url('public/disfrazs/' . $item->img_path) }}"
                                                            alt="{{ $item->nombre }}"
                                                            class="img-fluid .img-thumbnail border border-4 rounded">
                                                    @else
                                                        <img src="" alt="{{ $item->nombre }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion</h1>
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
