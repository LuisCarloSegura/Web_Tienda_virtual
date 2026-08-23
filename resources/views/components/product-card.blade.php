@props(['producto'])

<div class="col-6 col-md-4 col-lg-3">
    <div class="card h-100 border-0 shadow-sm product-card">

        <div class="position-relative product-card-img-wrap">
 
            <div class="ratio ratio-1x1 bg-light">
                <a href="{{ \Illuminate\Support\Facades\Route::has('productos.show') ? route('productos.show', $producto) : '#' }}"
                   class="d-flex align-items-center justify-content-center w-100 h-100">
                    @if($producto->imagenPrincipal)
                        @php
                            $urlImg = $producto->imagenPrincipal->url_imagen;
                            $src = str_starts_with($urlImg, 'http') ? $urlImg : asset($urlImg);
                        @endphp
                        <img src="{{ $src }}"
                             class="w-100 h-100 object-fit-cover"
                             alt="{{ $producto->nombre }}">
                    @else
                        <i class="bi bi-image fs-1 text-secondary"></i>
                    @endif
                </a>
            </div>
            {{--Boton de agregar al carrito--}}
            <a href=""
               class="btn btn-purple add-to-cart-overlay">
                Añadir al carrito
            </a>
        </div>
 
        <div class="card-body d-flex flex-column">
            <h6 class="card-title mb-1">{{ $producto->nombre }}</h6>
            <div class="fw-bold text-purple mb-2">₡{{ number_format($producto->precio, 0, ',', '.') }}</div>
            <a href="{{ route('productos.show', $producto) }}"
               class="btn btn-outline-purple btn-sm mt-auto">
                Ver producto
            </a>
        </div>
    </div>
</div>