@extends('layouts.admin')

@section('contenido')

    <h2 class="fw-bold mb-4">
        {{ isset($producto) ? 'Editar producto' : 'Nuevo producto' }}
    </h2>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ isset($producto) ? route('admin.productos.update', $producto) : route('admin.productos.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @isset($producto)
                    @method('PUT')
                @endisset

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Nombre</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $producto->nombre ?? '') }}">
                        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Categoría</label>
                        <select name="id_categoria" class="form-select @error('id_categoria') is-invalid @enderror">
                            <option value="">-- Seleccioná --</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}"
                                    {{ old('id_categoria', $producto->id_categoria ?? '') == $categoria->id_categoria ? 'selected' : '' }}>
                                    {{ $categoria->padre ? '— ' : '' }}{{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Precio (₡)</label>
                        <input type="number" step="0.01" name="precio" class="form-control @error('precio') is-invalid @enderror"
                               value="{{ old('precio', $producto->precio ?? '') }}">
                        @error('precio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Stock</label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', $producto->stock ?? 0) }}">
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Imagen</label>
                        <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*">
                        @error('imagen') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        @isset($producto)
                            @if($producto->imagenPrincipal)
                                <img src="{{ asset($producto->imagenPrincipal->url_imagen) }}"
                                     class="rounded mt-2" style="width:80px;height:80px;object-fit:cover;">
                                <div class="form-text">Subí una nueva solo si querés reemplazarla.</div>
                            @endif
                        @endisset
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                        @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-purple">
                        <i class="bi bi-check-lg me-1"></i> Guardar
                    </button>
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

@endsection