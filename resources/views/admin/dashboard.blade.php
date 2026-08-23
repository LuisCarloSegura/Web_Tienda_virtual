@extends('layouts.admin')

@section('contenido')

    <h2 class="fw-bold mb-4">Dashboard</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-box-seam fs-1 text-purple"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $totalProductos }}</div>
                        <div class="text-secondary small">Productos totales</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-tags fs-1 text-purple"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $totalCategorias }}</div>
                        <div class="text-secondary small">Categorías</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                    <div>
                        <div class="fs-4 fw-bold">{{ $sinStock }}</div>
                        <div class="text-secondary small">Productos sin stock</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-bold">Últimos productos agregados</span>
            <a href="{{ route('admin.productos.index') }}" class="btn btn-sm btn-outline-purple">Ver todos</a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosProductos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->categoria->nombre ?? '—' }}</td>
                            <td>₡{{ number_format($producto->precio, 0, ',', '.') }}</td>
                            <td>{{ $producto->stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-secondary py-4">Todavía no hay productos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection