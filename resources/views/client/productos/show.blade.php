@include('partials.header')

<div class="container py-5">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Inicio</a></li>
            @if($producto->categoria)
                <li class="breadcrumb-item">
                    <a href="{{ route('categorias.show', $producto->categoria->slug) }}" class="text-decoration-none">
                        {{ $producto->categoria->nombre }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $producto->nombre }}</li>
        </ol>
    </nav>

    <div class="row g-5">

        {{-- GALERÍA DE IMÁGENES --}}
        <div class="col-12 col-md-6">
            @php
                $principal = $producto->imagenes->first();
            @endphp

            <div class="ratio ratio-1x1 bg-light rounded mb-3 d-flex align-items-center justify-content-center">
                @if($principal)
                    @php
                        $src = str_starts_with($principal->url_imagen, 'http')
                            ? $principal->url_imagen
                            : asset($principal->url_imagen);
                    @endphp
                    <img id="imagenPrincipal" src="{{ $src }}" class="w-100 h-100 object-fit-cover rounded" alt="{{ $producto->nombre }}">
                @else
                    <i class="bi bi-image display-1 text-secondary"></i>
                @endif
            </div>

            @if($producto->imagenes->count() > 1)
                <div class="d-flex gap-2">
                    @foreach($producto->imagenes as $imagen)
                        @php
                            $thumbSrc = str_starts_with($imagen->url_imagen, 'http')
                                ? $imagen->url_imagen
                                : asset($imagen->url_imagen);
                        @endphp
                        <img src="{{ $thumbSrc }}"
                             class="rounded border thumb-img"
                             style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;"
                             onclick="document.getElementById('imagenPrincipal').src = this.src"
                             alt="{{ $producto->nombre }}">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- INFORMACIÓN DEL PRODUCTO --}}
        <div class="col-12 col-md-6">
            <h2 class="fw-bold mb-2">{{ $producto->nombre }}</h2>

            <div class="fs-3 fw-bold text-purple mb-3">
                ₡{{ number_format($producto->precio, 0, ',', '.') }}
            </div>

            @if($producto->stock > 0)
                <span class="badge bg-success mb-3">En stock ({{ $producto->stock }} disponibles)</span>
            @else
                <span class="badge bg-danger mb-3">Agotado</span>
            @endif

            <p class="text-secondary">
                {{ $producto->descripcion ?? 'Sin descripción disponible.' }}
            </p>

            <a href="#"
               class="btn btn-purple btn-lg d-inline-flex align-items-center gap-2 mt-3">
                <i class="bi bi-cart-plus"></i> Agregar al carrito
            </a>
        </div>
    </div>
</div>

@include('partials.footer')