<form action="{{ route('categorias.update', ['categoria' => $categoria]) }}" method="post">
    @method('PATCH')
    @csrf
    <div class="mb-3">
        <label for="nombre-{{ $categoria->id }}" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre-{{ $categoria->id }}" class="form-control"
            value="{{ old('nombre', $categoria->nombre) }}">
        @error('nombre')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="mb-3">
        <label for="descripcion-{{ $categoria->id }}" class="form-label">Descripción</label>
        <textarea name="descripcion" id="descripcion-{{ $categoria->id }}" rows="3" class="form-control">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        @error('descripcion')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
