<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - TechStore CR / TecnoNova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <a href="{{ url('/') }}" class="text-white text-decoration-none d-inline-flex align-items-center mb-3">
                <span class="text-primary me-1 fs-2 fw-bold">✕</span>
                <span class="fs-2 fw-bold">Kontech</span>
            </a>
            <h2 class="fw-bold fs-4 mb-1">Iniciar Sesión</h2>
            <p class="small text-white-50 mb-0">Accede a tu cuenta de cliente en nuestra tienda virtual</p>
        </div>

        <div class="login-body">
            @if (session('status') || session('exito') || session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 small mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') ?? session('exito') ?? session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 small mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold small text-dark mb-1">Correo Electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control bg-light rounded-3 py-2 text-dark @error('email') is-invalid @enderror"
                        placeholder="ejemplo@correo.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback d-block small mt-1">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold small text-dark mb-1">Contraseña</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control bg-light border-end-0 rounded-start-3 py-2 text-dark @error('password') is-invalid @enderror"
                            placeholder="Tu contraseña"
                            required
                            minlength="8"
                        >
                        <button class="btn btn-light border border-start-0 text-secondary rounded-end-3 px-3" type="button" id="togglePasswordBtn">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block small mt-1">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-muted" for="remember">Recordarme</label>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-purple btn-lg rounded-pill py-2 fw-bold text-uppercase shadow-sm">
                        Iniciar Sesión
                    </button>
                </div>

                <div class="text-center pt-3 border-top">
                    <p class="small text-muted mb-2">
                        ¿Aún no tienes una cuenta?
                        <a href="{{ route('registro') }}" class="text-purple fw-bold text-decoration-none">
                            Regístrate aquí
                        </a>
                    </p>
                    <a href="{{ url('/') }}" class="small text-secondary text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Volver a la tienda
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            toggleBtn?.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                toggleIcon.classList.toggle('bi-eye', !isPassword);
                toggleIcon.classList.toggle('bi-eye-slash', isPassword);
            });
        });
    </script>
</body>
</html>