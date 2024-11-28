@extends('template')

@section('title', 'Pieza')

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
        <h1 class="mt-4 text-center">Pieza</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Pieza</li>
        </ol>
        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formPiezaModal">
                Añadir nuevo registro
            </button>
        </div>
        <!-- Modal para Crear Pieza -->
        <div class="modal fade" id="formPiezaModal" tabindex="-1" aria-labelledby="formPiezaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formPiezaModalLabel">Añadir Nueva Pieza</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('pieza.create')
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla pieza
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($piezas as $pieza)
                            <tr>
                                <td>{{ $pieza->nombre }}</td>
                                <td>{{ $pieza->tipo }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal-{{ $pieza->id }}">
                                            Editar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal para Editar Pieza -->
                            <div class="modal fade" id="editModal-{{ $pieza->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel-{{ $pieza->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel-{{ $pieza->id }}">Editar Pieza
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('pieza.edit', ['pieza' => $pieza])
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

    <!-- Mostrar el Modal de Creación si Hay Errores -->
    @if ($errors->any() && session('is_create'))
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('formPiezaModal'));
            myModal.show();
        </script>
    @endif

    <!-- Mostrar el Modal de Edición si Hay Errores -->
    @if ($errors->any() && session('edit_id'))
        <script>
            var editModal = new bootstrap.Modal(document.getElementById('editModal-{{ session('edit_id') }}'));
            editModal.show();
        </script>
    @endif

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
