@include('partials.header')

<main class="py-5 bg-light min-vh-100">
    <div class="container">
        
        {{-- TÍTULO Y BREADCRUMB --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0 text-dark">Mi Cuenta</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-purple text-decoration-none">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mi Cuenta</li>
                </ol>
            </nav>
        </div>

        {{-- MENSAJES DE FEEDBACK VISUAL --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Por favor corrija los errores señalados a continuación.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- COLUMNA IZQUIERDA: MENÚ LATERAL --}}
            <div class="col-lg-3 col-md-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('Imágenes/Avatar/Avatar.png') }}" alt="Avatar {{ $user->nombre }}" class="rounded-circle border border-2 border-purple" style="width: 45px; height: 45px; object-fit: cover;">
                            <div class="overflow-hidden">
                                <h6 class="fw-bold text-dark mb-0 text-truncate">{{ $user->nombre }} {{ $user->primer_apellido }}</h6>
                                <small class="text-muted text-truncate d-block">{{ $user->email }}</small>
                            </div>
                        </div>
                    </div>
                    
                    {{-- MENÚ LATERAL CON ÚNICAMENTE LAS 3 OPCIONES SOLICITADAS --}}
                    <div class="list-group list-group-flush border-0 py-2" id="account-tab" role="tablist">
                        
                        {{-- Opción 1: Pedidos --}}
                        <button class="list-group-item list-group-item-action py-3 px-4 d-flex align-items-center gap-3 border-0 text-secondary fw-semibold" id="pedidos-tab" data-bs-toggle="pill" data-bs-target="#pedidos-content" type="button" role="tab" aria-controls="pedidos-content" aria-selected="false">
                            <i class="bi bi-box-seam text-purple fs-5"></i>
                            <span>Pedidos</span>
                        </button>

                        {{-- Opción 2: Detalles de la cuenta (Seleccionada y visible por defecto) --}}
                        <button class="list-group-item list-group-item-action py-3 px-4 d-flex align-items-center gap-3 border-0 text-purple fw-bold active bg-light" id="detalles-tab" data-bs-toggle="pill" data-bs-target="#detalles-content" type="button" role="tab" aria-controls="detalles-content" aria-selected="true" style="border-left: 4px solid #7c3aed !important;">
                            <i class="bi bi-person-circle text-purple fs-5"></i>
                            <span>Detalles de la cuenta</span>
                        </button>

                        {{-- Opción 3: Lista de deseos --}}
                        <button class="list-group-item list-group-item-action py-3 px-4 d-flex align-items-center gap-3 border-0 text-secondary fw-semibold" id="deseos-tab" data-bs-toggle="pill" data-bs-target="#deseos-content" type="button" role="tab" aria-controls="deseos-content" aria-selected="false">
                            <i class="bi bi-heart text-purple fs-5"></i>
                            <span>Lista de deseos</span>
                        </button>
                    </div>

                    {{-- BOTÓN CERRAR SESIÓN EN LA PARTE INFERIOR DEL MENÚ LATERAL --}}
                    <div class="card-footer bg-white border-top p-3 text-center">
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- COLUMNA DERECHA: CONTENIDO --}}
            <div class="col-lg-9 col-md-8">
                <div class="tab-content" id="account-tabContent">
                    
                    {{-- TAB CONTENIDO: PEDIDOS --}}
                    <div class="tab-pane fade" id="pedidos-content" role="tabpanel" aria-labelledby="pedidos-tab">
                        <div class="card border-0 shadow-sm rounded-3 p-4">
                            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-box-seam text-purple me-2"></i>Mis Pedidos</h5>
                            <p class="text-muted mb-0">Aún no tienes pedidos realizados en la tienda.</p>
                        </div>
                    </div>

                    {{-- TAB CONTENIDO: DETALLES DE LA CUENTA (VISIBLE POR DEFECTO) --}}
                    <div class="tab-pane fade show active" id="detalles-content" role="tabpanel" aria-labelledby="detalles-tab">
                        <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5">
                            <div class="border-bottom pb-3 mb-4">
                                <h4 class="fw-bold text-dark mb-1">Detalles de la cuenta</h4>
                                <p class="text-muted small mb-0">Actualiza tu información personal y tus credenciales de acceso.</p>
                            </div>

                            <form action="{{ route('perfil.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- SECCIÓN: DATOS PERSONALES --}}
                                <h6 class="fw-bold text-purple mb-3"><i class="bi bi-person me-2"></i>Datos personales</h6>
                                
                                <div class="row g-3 mb-4">
                                    {{-- Nombre --}}
                                    <div class="col-md-4">
                                        <label for="nombre" class="form-label fw-semibold text-dark small">Nombre</label>
                                        <input type="text" class="form-control py-2 @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $user->nombre) }}" required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Primer Apellido --}}
                                    <div class="col-md-4">
                                        <label for="primer_apellido" class="form-label fw-semibold text-dark small">Primer Apellido</label>
                                        <input type="text" class="form-control py-2 @error('primer_apellido') is-invalid @enderror" id="primer_apellido" name="primer_apellido" value="{{ old('primer_apellido', $user->primer_apellido) }}" required>
                                        @error('primer_apellido')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Segundo Apellido --}}
                                    <div class="col-md-4">
                                        <label for="segundo_apellido" class="form-label fw-semibold text-dark small">Segundo Apellido</label>
                                        <input type="text" class="form-control py-2 @error('segundo_apellido') is-invalid @enderror" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido', $user->segundo_apellido) }}" required>
                                        @error('segundo_apellido')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-12">
                                        <label for="email" class="form-label fw-semibold text-dark small">Dirección de correo electrónico / Email</label>
                                        <input type="email" class="form-control py-2 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-4 text-muted opacity-25">

                                {{-- SECCIÓN: CAMBIO DE CONTRASEÑA --}}
                                <h6 class="fw-bold text-purple mb-2"><i class="bi bi-shield-lock me-2"></i>Cambio de contraseña</h6>
                                <p class="text-muted small mb-3">Deja estos campos en blanco si no deseas cambiar tu contraseña actual.</p>

                                <div class="row g-3 mb-4">
                                    {{-- Contraseña actual --}}
                                    <div class="col-12">
                                        <label for="password_actual" class="form-label fw-semibold text-dark small">Contraseña actual</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control py-2 @error('password_actual') is-invalid @enderror" id="password_actual" name="password_actual" placeholder="Ingresa tu contraseña actual">
                                            <button class="btn btn-outline-secondary px-3" type="button" onclick="toggleAllPasswordsVisibility()">
                                                <i class="bi bi-eye" id="eye_icon_actual"></i>
                                            </button>
                                            @error('password_actual')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Nueva contraseña --}}
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-semibold text-dark small">Nueva contraseña</label>
                                        <input type="password" class="form-control py-2 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Mínimo 8 caracteres">
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Confirmar nueva contraseña --}}
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label fw-semibold text-dark small">Confirmar nueva contraseña</label>
                                        <input type="password" class="form-control py-2 @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Repite la nueva contraseña">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- BOTONES DE ACCIÓN --}}
                                <div class="d-flex justify-content-end gap-3 pt-3">
                                    <a href="{{ route('dashboard') }}" class="btn btn-light border px-4 py-2 fw-semibold">Cancelar</a>
                                    <button type="submit" class="btn btn-purple px-4 py-2 fw-semibold shadow-sm">
                                        <i class="bi bi-save me-2"></i>Guardar cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- TAB CONTENIDO: LISTA DE DESEOS --}}
                    <div class="tab-pane fade" id="deseos-content" role="tabpanel" aria-labelledby="deseos-tab">
                        <div class="card border-0 shadow-sm rounded-3 p-4">
                            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-heart text-purple me-2"></i>Lista de deseos</h5>
                            <p class="text-muted mb-0">Tu lista de deseos se encuentra vacía.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

{{-- SCRIPT LIVIANO PARA VISIBILIDAD DE CONTRASEÑA (OJITO) Y CONTROL DE TAB --}}
<script>
    function toggleAllPasswordsVisibility() {
        const passwordInputs = [
            document.getElementById('password_actual'),
            document.getElementById('password'),
            document.getElementById('password_confirmation')
        ];
        const icon = document.getElementById('eye_icon_actual');
        
        if (passwordInputs[0] && icon) {
            const shouldShow = passwordInputs[0].type === 'password';
            passwordInputs.forEach(input => {
                if (input) {
                    input.type = shouldShow ? 'text' : 'password';
                }
            });
            if (shouldShow) {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Asegurar comportamiento visual activo del menú lateral
        const tabButtons = document.querySelectorAll('#account-tab button');
        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'text-purple', 'fw-bold', 'bg-light');
                    btn.classList.add('text-secondary', 'fw-semibold');
                    btn.style.borderLeft = 'none';
                });
                this.classList.add('active', 'text-purple', 'fw-bold', 'bg-light');
                this.classList.remove('text-secondary', 'fw-semibold');
                this.style.borderLeft = '4px solid #7c3aed';
            });
        });
    });
</script>

@include('partials.footer')
