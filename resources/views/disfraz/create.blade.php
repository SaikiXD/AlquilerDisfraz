<form id="form-disfraz" method="POST" action="{{ route('disfrazs.store') }}">
    @csrf
    <!-- Título -->
    <h3 class="text-center mb-4">Registrar Nuevo Disfraz</h3>

    <!-- Paso 1: Información General -->
    <div id="step-1" class="form-step">
        <h5 class="mb-3">Paso 1: Información General</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre del Disfraz</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}"
                    required>
                <div class="invalid-feedback">Este campo es obligatorio.</div>
            </div>
            <div class="col-md-6">
                <label for="genero" class="form-label">Género</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="" disabled selected>Seleccione el género</option>
                    <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="unisex" {{ old('genero') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                </select>
                <div class="invalid-feedback">Este campo es obligatorio.</div>
            </div>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4"
                placeholder="Escriba una breve descripción del disfraz">{{ old('descripcion') }}</textarea>
        </div>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary px-4" onclick="nextStep(2)">Siguiente</button>
        </div>
    </div>

    <!-- Paso 2: Selección de Piezas -->
    <div id="step-2" class="form-step d-none">
        <h5 class="mb-4 text-center">Paso 2: Selección de Piezas</h5>
        <div id="piezas-container" class="mb-4">
            <div class="card p-3 mb-3 shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label class="form-label">Tipo de Pieza</label>
                        <select class="form-select tipo-select" required>
                            <option value="" disabled selected>Seleccione un tipo</option>
                            @foreach ($piezas_tipo as $tipo => $piezas)
                                <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pieza</label>
                        <select class="form-select pieza-select" name="piezas[]" required disabled>
                            <option value="" disabled selected>Seleccione una pieza</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad[]" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Color</label>
                        <input type="text" class="form-control" name="color[]">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Talla</label>
                        <input type="text" class="form-control" name="talla[]">
                    </div>
                    <div class="col-md-1 d-flex align-items-center justify-content-center mt-4">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-pieza-btn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" onclick="prevStep(1)">
                <i class="fas fa-arrow-left"></i> Anterior
            </button>
            <button type="button" class="btn btn-primary" id="add-pieza-btn">
                <i class="fas fa-plus"></i> Añadir otra pieza
            </button>
            <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                Siguiente <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>
    <!--paso 3-->
    <div id="step-3" class="form-step d-none">
        <!-- Título del Paso 3 -->
        <h5 class="mb-3">Paso 3: Configuración</h5>

        <!-- Categorías -->
        <div class="mb-3">
            <label for="categorias" class="form-label">Categorías</label>
            <select class="form-control selectpicker" data-size="5" data-live-search="true"
                title="Seleccione las categorías" name="categorias[]" id="categorias" multiple>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ in_array($categoria->id, old('categorias', [])) ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categorias')
                <small class="text-danger">{{ '*' . $message }}</small>
            @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01"
                value="{{ old('precio') }}" placeholder="Ejemplo: 120.00" required>
            @error('precio')
                <small class="text-danger">{{ '*' . $message }}</small>
            @enderror
        </div>

        <!-- Subida de Imagen -->
        <div class="mb-3">
            <label for="img_path" class="form-label">Subir Imagen del Disfraz</label>
            <input type="file" class="form-control" id="img_path" name="img_path" accept="image/*" required>
            @error('img_path')
                <small class="text-danger">{{ '*' . $message }}</small>
            @enderror
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary px-4" onclick="prevStep(2)">Anterior</button>
            <button type="button" class="btn btn-primary px-4" onclick="nextStep(4)">Siguiente</button>
        </div>
    </div>
    <div id="step-4" class="form-step d-none">
        <!-- Título del Paso 4 -->
        <h5 class="mb-3">Paso 4: Confirmación</h5>

        <!-- Resumen de Información General -->
        <div class="mb-3">
            <h6>Información General</h6>
            <p><strong>Nombre del Disfraz:</strong> <span id="confirm-nombre"></span></p>
            <p><strong>Género:</strong> <span id="confirm-genero"></span></p>
            <p><strong>Descripción:</strong> <span id="confirm-descripcion"></span></p>
        </div>

        <!-- Resumen de Piezas Seleccionadas -->
        <div class="mb-3">
            <h6>Piezas Seleccionadas</h6>
            <ul id="confirm-piezas">
                <!-- Aquí se llenarán las piezas seleccionadas dinámicamente -->
            </ul>
        </div>

        <!-- Resumen de Categorías, Precio, e Imagen -->
        <div class="mb-3">
            <h6>Configuración</h6>
            <p><strong>Categorías:</strong> <span id="confirm-categorias"></span></p>
            <p><strong>Precio:</strong> <span id="confirm-precio"></span></p>
            <div>
                <strong>Imagen del Disfraz:</strong>
                <div id="confirm-imagen" class="mt-2">
                    <!-- Imagen previa cargada -->
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary px-4" onclick="prevStep(3)">Anterior</button>
            <button type="submit" class="btn btn-success px-4">Confirmar y Guardar</button>
        </div>
    </div>
</form>
