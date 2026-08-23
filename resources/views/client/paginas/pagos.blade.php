{{-- resources/views/client/paginas/pagos.blade.php --}}
@include('partials.head')
@include('partials.header')

<main>
    {{-- HERO --}}
    <div class="custom-navbar-top text-white text-center py-5">
        <div class="container">
            <h1 class="fw-bold display-6 mb-2">Métodos de Pago</h1>
            <p class="text-white-50 mb-0">Pagá de la forma que más te convenga, de manera segura.</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-4">

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <i class="bi bi-credit-card-2-front fs-1 text-purple mb-3"></i>
                    <h6 class="fw-bold">Tarjeta de Crédito</h6>
                    <p class="text-secondary small mb-0">Visa, Mastercard y American Express.</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <i class="bi bi-credit-card fs-1 text-purple mb-3"></i>
                    <h6 class="fw-bold">Tarjeta de Débito</h6>
                    <p class="text-secondary small mb-0">Aceptamos débito de los principales bancos.</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <i class="bi bi-phone fs-1 text-purple mb-3"></i>
                    <h6 class="fw-bold">SINPE Móvil</h6>
                    <p class="text-secondary small mb-0">Pagá al instante desde tu celular.</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <i class="bi bi-bank fs-1 text-purple mb-3"></i>
                    <h6 class="fw-bold">Transferencia Bancaria</h6>
                    <p class="text-secondary small mb-0">Transferí directo a nuestra cuenta.</p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-5">
            <div class="card-body d-flex align-items-start gap-3">
                <i class="bi bi-shield-check fs-2 text-purple"></i>
                <div>
                    <h6 class="fw-bold mb-1">Pagos 100% seguros</h6>
                    <p class="text-secondary small mb-0">
                        Todos tus pagos se procesan de forma cifrada. Nunca almacenamos
                        los datos completos de tu tarjeta en nuestros servidores.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

@include('partials.footer')
@include('partials.scripts')