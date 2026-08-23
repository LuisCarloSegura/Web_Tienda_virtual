@extends('layouts.admin')

@section('contenido')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Productos</h2>
        <a href="{{ route('admin.productos.create') }}" class="btn btn-purple">
            <i class="bi bi-plus-lg me-1"></i> Nuevo producto
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th style="width: 140px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>
                                @if($producto->imagenPrincipal)
                                    <img src="{{ asset($producto->imagenPrincipal->url_imagen) }}"
                                         class="rounded" style="width:48px;height:48px;object-fit:cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                                        <i class="bi bi-image text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->categoria->nombre ?? '—' }}</td>
                            <td>₡{{ number_format($producto->precio, 0, ',', '.') }}</td>
                            <td>
                                @if($producto->stock > 0)
                                    <span class="badge bg-success">{{ $producto->stock }}</span>
                                @else
                                    <span class="badge bg-danger">0</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-sm btn-outline-purple">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST"
                                          onsubmit="return confirm('¿Seguro que querés eliminar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-secondary py-4">Todavía no hay productos creados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $productos->links() }}
    </div>

@endsection