<form action="{{ route('piezas.update', ['pieza' => $pieza]) }}" method="post">
    @method('PATCH')
    @csrf
    <div class="row g-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre-{{ $pieza->id }}" class="form-control"
                value="{{ old('nombre', $pieza->nombre) }}">
            @error('nombre')
                <small class="text-danger">{{ '*' . $message }}</small>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="tipo" class="form-label">Tipo de pieza:</label>
            <select title="Seleccione el tipo de pieza" name="tipo" id="tipo-{{ $pieza->id }}"
                class="form-control selectpicker">
                <option value="Prendas de vestir"
                    {{ old('tipo', $pieza->tipo) == 'Prendas de vestir' ? 'selected' : '' }}>
                    Prendas de vestir
                </option>
                <option value="Accesorios" {{ old('tipo', $pieza->tipo) == 'Accesorios' ? 'selected' : '' }}>
                    Accesorios
                </option>
                <option value="Elementos de fantasía"
                    {{ old('tipo', $pieza->tipo) == 'Elementos de fantasía' ? 'selected' : '' }}>
                    Elementos de fantasía
                </option>
                <option value="Armas y herramientas"
                    {{ old('tipo', $pieza->tipo) == 'Armas y herramientas' ? 'selected' : '' }}>
                    Armas y herramientas
                </option>
            </select>
            @error('tipo')
                <small class="text-danger">{{ '*' . $message }}</small>
            @enderror
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
    </div>
</form>
