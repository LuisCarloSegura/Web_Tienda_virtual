@include('partials.head')
@include('partials.header')

<div class="container py-4">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="footer-link text-decoration-none text-dark">Inicio</a></li>
            @if($categoria->padre)
                <li class="breadcrumb-item">
                    <a href="{{ route('categorias.show', $categoria->padre->slug) }}" class="text-decoration-none">
                        {{ $categoria->padre->nombre }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $categoria->nombre }}</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-3">{{ $categoria->nombre }}</h2>

    @if($categoria->subcategorias->isNotEmpty())
        <div class="d-flex flex-wrap gap-2 mb-4">
            @foreach($categoria->subcategorias as $sub)
                <a href="{{ route('categorias.show', $sub->slug) }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    {{ $sub->nombre }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="row g-4">
        @forelse($productos as $producto)
            <x-product-card :producto="$producto" />
        @empty
            <p class="text-secondary">No hay productos en esta categoría todavía.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $productos->links() }}
    </div>
</div>

@include('partials.footer')
@include('partials.scripts')