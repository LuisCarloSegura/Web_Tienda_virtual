<body>
   <header>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        {{-- ============ BARRA SUPERIOR ============ --}}
        <nav class="navbar navbar-expand-lg navbar-dark custom-navbar-top py-3">
            <div class="container-fluid px-4">

                {{-- LOGO --}}
                <a class="navbar-brand fw-bold fs-3 d-flex align-items-center" href="{{ url('/') }}">
                    <span class="text-primary me-1">✕</span>Kontech
                </a>

                {{-- BUSCADOR (oculto en móvil chico) --}}
                <form class="d-none d-sm-flex flex-grow-1 mx-4" action="" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0 rounded-start-pill ps-3">
                            <i class="bi bi-search text-secondary"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-0 rounded-end-pill pe-4" placeholder="Busqueda de Productos...">
                    </div>
                </form>

                <div class="d-flex align-items-center gap-3 ms-auto">
                    @auth
                        <div class="dropdown d-none d-sm-block">
                            <a href="#" class="text-white text-decoration-none small fw-semibold dropdown-toggle d-flex align-items-center gap-2" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('Imágenes/Avatar/Avatar.png') }}" alt="Avatar {{ Auth::user()->nombre ?? Auth::user()->name }}" class="rounded-circle shadow-sm border border-2 border-white" style="width: 35px; height: 35px; object-fit: cover;">
                                <div class="d-flex flex-column text-start">
                                    <span class="fw-semibold lh-1">{{ Auth::user()->nombre ?? Auth::user()->name }}</span>
                                    <span class="text-white-50 small lh-1 mt-1" style="font-size: 0.7rem;">{{ Auth::user()->email }}</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3 overflow-hidden" aria-labelledby="userDropdown" style="min-width: 220px;">
                                <li>
                                    <div class="px-3 py-2 border-bottom bg-light">
                                        <div class="fw-bold small text-dark text-truncate">{{ Auth::user()->nombre ?? Auth::user()->name }}</div>
                                        <div class="small text-muted text-truncate" style="font-size: 0.75rem;">{{ Auth::user()->email }}</div>
                                        {{-- Indicador dinámico del rol del usuario autenticado --}}
                                        <span class="badge {{ Auth::user()->esAdministrador() ? 'bg-danger' : 'bg-primary' }} text-white mt-1" style="font-size: 0.65rem;">
                                            {{ ucfirst(Auth::user()->rol ?? 'cliente') }}
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 text-dark small fw-semibold d-flex align-items-center gap-2" href="#">
                                        <i class="bi bi-pencil-square text-purple fs-6"></i>Cambiar
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout.switch') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-dark small fw-semibold d-flex align-items-center gap-2 w-100 border-0 bg-transparent text-start">
                                            <i class="bi bi-arrow-repeat text-purple fs-6"></i>Cambiar de cuenta
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger small fw-semibold d-flex align-items-center gap-2 w-100 border-0 bg-transparent text-start">
                                            <i class="bi bi-box-arrow-right fs-6"></i>Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                                
                                {{-- ============ OPCIONES DINÁMICAS SEGÚN EL ROL ============ --}}
                                <li><hr class="dropdown-divider my-1"></li>
                                @if(Auth::user()->esAdministrador())
                                    {{-- Opciones exclusivas para Administradores (Gestión y modificación de productos) --}}
                                    <li>
                                        <a class="dropdown-item py-2 text-dark small fw-semibold d-flex align-items-center gap-2" href="#">
                                            <i class="bi bi-box-seam text-purple fs-6"></i>Gestión de productos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 text-dark small fw-semibold d-flex align-items-center gap-2" href="#">
                                            <i class="bi bi-pencil-square text-purple fs-6"></i>Modificación de productos
                                        </a>
                                    </li>
                                @else
                                    {{-- Opciones exclusivas para Clientes (Historial de compras) --}}
                                    <li>
                                        <a class="dropdown-item py-2 text-dark small fw-semibold d-flex align-items-center gap-2" href="#">
                                            <i class="bi bi-bag-check text-purple fs-6"></i>Historial de compras
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white text-decoration-none small fw-semibold d-none d-sm-block">
                            ACCESO / REGISTRO
                        </a>
                    @endauth

                    {{-- ============ VISTA DE COMPRAS (Deseos y Carrito solo para Clientes o Invitados) ============ --}}
                    @if(!Auth::check() || !Auth::user()->esAdministrador())
                        <a href="" class="text-white fs-5">
                            <i class="bi bi-heart"></i>
                        </a>

                        <a href="" class="text-white text-decoration-none d-flex align-items-center gap-2 position-relative">
                            <span class="position-relative fs-5">
                                <i class="bi bi-cart3"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-purple" style="font-size: .6rem;">
                                    {{ $cartCount ?? 0 }}
                                </span>
                            </span>
                            <span class="d-none d-md-inline fw-semibold small">₡{{ $cartTotal ?? 0 }}</span>
                        </a>
                    @endif

                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>

            {{-- buscador en móvil --}}
            <div class="d-sm-none px-4 pt-3 w-100">
                <form action="" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0 rounded-start-pill ps-3">
                            <i class="bi bi-search text-secondary"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-0 rounded-end-pill pe-4" placeholder="Busqueda de Productos...">
                    </div>
                </form>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg bg-white border-bottom">
            <div class="container-fluid px-4">
                <div class="collapse navbar-collapse justify-content-center" id="navMenu">
                    <ul class="navbar-nav align-items-lg-center gap-lg-4 py-2 py-lg-0">

                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold text-dark d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list fs-5"></i> VER CATEGORÍAS
                        </a>
                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item" href="{{ \Illuminate\Support\Facades\Route::has('categorias.show') ? route('categorias.show', 'laptops') : '#' }}">Laptops</a></li>
                                <li><a class="dropdown-item" href="{{ \Illuminate\Support\Facades\Route::has('categorias.show') ? route('categorias.show', 'celulares') : '#' }}">Celulares</a></li>
                                <li><a class="dropdown-item" href="">Audio</a></li>
                                <li><a class="dropdown-item" href="">TV y proyección</a></li>
                            </ul>
                        </li>

                        {{-- ÍCONO CASA / INICIO --}}
                        <li class="nav-item">
                            <a class="nav-link text-dark fs-5" href="{{ url('/') }}" title="Inicio">
                                <i class="bi bi-house-door"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fw-bold text-dark" href="">SOBRE NOSOTROS</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fw-bold text-dark" href="">METODOS DE PAGO</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fw-bold text-purple d-flex align-items-center gap-2" href="">
                                <i class="bi bi-envelope"></i> CONTÁCTANOS
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>