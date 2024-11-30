
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
    <h5 class="mb-3">Paso 2: Selección de Piezas</h5>
    <!-- Contenedor para filas dinámicas -->
    <div id="piezas-container">
        <!-- Este contenedor estará vacío inicialmente, las filas se agregarán dinámicamente -->
</div>

    <!-- Botón para añadir una nueva pieza -->
    <div class="mb-3 text-end">
        <button type="button" id="add-pieza-btn" class="btn btn-primary">
            <i class="fas fa-plus"></i> Añadir otra pieza
        </button>
    </div>

    <!-- Botones de navegación -->
    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-secondary px-4" onclick="prevStep(1)">Anterior</button>
        <button type="button" class="btn btn-primary px-4" onclick="nextStep(3)">Siguiente</button>
    </div>
</div>
    <!--paso 3-->
    <div id="step-3" class="form-step d-none">
        <!-- Título del Paso 3 -->
        <h5 class="mb-3">Paso 3: Configuración</h5>

        <!-- Categorías -->
        <div class="mb-3">
            <label for="categorias" class="form-label">Categorías</label>
            <select 
                class="form-control selectpicker @error('categorias') is-invalid @enderror" 
                data-live-search="true" 
                name="categorias[]" 
                id="categorias" 
                multiple>
                <option value="" disabled>Seleccione las categorías</option>
                @foreach ($categorias as $categoria)
                    <option 
                        value="{{ $categoria->id }}" 
                        {{ collect(old('categorias'))->contains($categoria->id) ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categorias')
                <div class="invalid-feedback">{{ $message }}</div>
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
