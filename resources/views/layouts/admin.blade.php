<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administración - {{ config('app.name', 'Nombre Empresa') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        body { background-color: #f4f5f7; }
        .admin-sidebar {
            background: linear-gradient(180deg, #000000 0%, #1e1b4b 55%, #4c1d95 100%);
            min-height: 100vh;
            width: 240px;
        }
        .admin-sidebar .nav-link {
            color: rgba(255,255,255,.75);
            border-radius: .5rem;
        }
        .admin-sidebar .nav-link.active,
        .admin-sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        .admin-content { flex: 1; }
    </style>
</head>
<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <nav class="admin-sidebar p-3 flex-shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-white text-decoration-none mb-4 fs-5 fw-bold">
            <span class="text-primary me-1">✕</span>{{ config('app.name', 'Nombre Empresa') }}
        </a>

        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.productos.index') }}" class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam me-2"></i> Productos
                </a>
            </li>
        </ul>

        <hr class="text-white-50 my-4">

        <a href="{{ url('/') }}" class="nav-link text-white-50">
            <i class="bi bi-shop me-2"></i> Ver tienda
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link text-white-50 border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
            </button>
        </form>
    </nav>

    {{-- CONTENIDO --}}
    <div class="admin-content p-4">

        @if (session('exito'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('exito') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('contenido')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>