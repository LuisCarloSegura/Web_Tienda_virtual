{{-- resources/views/client/paginas/contacto.blade.php --}}
@include('partials.head')
@include('partials.header')

<main>
    <div class="custom-navbar-top text-white text-center py-5">
        <div class="container">
            <h1 class="fw-bold display-6 mb-2">Contáctanos</h1>
            <p class="text-white-50 mb-0">¿Tenés alguna duda? Escribinos, con gusto te ayudamos.</p>
        </div>
    </div>
 
    <div class="container py-5">
        <div class="row g-5">
 
            {{-- INFO DE CONTACTO --}}
            <div class="col-12 col-md-4">
                <h5 class="fw-bold mb-4">Información de contacto</h5>
 
                <div class="d-flex align-items-start gap-3 mb-4">
                    <i class="bi bi-telephone fs-4 text-purple"></i>
                    <div>
                        <div class="fw-bold">Teléfono</div>
                        <div class="text-secondary small">0000-0000</div>
                    </div>
                </div>
 
                <div class="d-flex align-items-start gap-3 mb-4">
                    <i class="bi bi-envelope fs-4 text-purple"></i>
                    <div>
                        <div class="fw-bold">Correo</div>
                        <div class="text-secondary small">info@nombreempresa.com</div>
                    </div>
                </div>
 
                <div class="d-flex align-items-start gap-3 mb-4">
                    <i class="bi bi-geo-alt fs-4 text-purple"></i>
                    <div>
                        <div class="fw-bold">Ubicación</div>
                        <div class="text-secondary small">Costa Rica</div>
                    </div>
                </div>
 
                <div class="d-flex align-items-start gap-3">
                    <i class="bi bi-clock fs-4 text-purple"></i>
                    <div>
                        <div class="fw-bold">Horario</div>
                        <div class="text-secondary small">Lunes a Viernes, 8:00am - 5:00pm</div>
                    </div>
                </div>
            </div>
 
            {{-- FORMULARIO --}}
            <div class="col-12 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Envianos un mensaje</h5>
 
                        {{-- TODO: falta la ruta y lógica de backend para
                             procesar el envío de este formulario --}}
                        <form action="#" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Correo</label>
                                    <input type="email" name="correo" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Asunto</label>
                                    <input type="text" name="asunto" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Mensaje</label>
                                    <textarea name="mensaje" rows="5" class="form-control" required></textarea>
                                </div>
                            </div>
 
                            <button type="submit" class="btn btn-purple mt-4">
                                <i class="bi bi-send me-1"></i> Enviar mensaje
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('partials.footer')
@include('partials.scripts')