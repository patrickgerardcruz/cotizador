<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta — Pixel Code</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-body">

<a href="{{ route('home') }}" class="auth-back-btn" aria-label="Volver al inicio">← Volver</a>

<div class="auth-shell">
    <div class="auth-visual">
        <div class="auth-brand">
            <span class="brand-mark"><span class="brand-angle">&lt;</span><span class="brand-slash">/</span><span class="brand-angle">&gt;</span></span>
            <span class="brand-word">PixelCode</span>
        </div>

        <h1 class="auth-hero-title">Construimos el futuro con software.</h1>
        <p class="auth-hero-copy">
            Crea tu cuenta y arma tu cotización con herramientas diseñadas para acelerar tu próximo proyecto digital.
        </p>
    </div>

    <div class="auth-form-panel">
        <div class="auth-form-box">
            <h2>Crear cuenta</h2>
            <p class="auth-subtitle">Registra tu proyecto y comienza.</p>

            <div class="auth-tabs" aria-label="auth tabs">
                <a href="{{ route('login') }}" class="auth-tab auth-tab-link">Iniciar sesión</a>
                <button type="button" class="auth-tab active">Crear cuenta</button>
            </div>

            @if ($errors->any())
                <div class="alert custom-alert mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="register-form">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre completo</label>
                    <div class="input-group auth-input-group">
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="empresa">Empresa <span class="text-danger">*</span></label>
                    <div class="input-group auth-input-group">
                        <input type="text" class="form-control" id="empresa" name="empresa" value="{{ old('empresa') }}" placeholder="Nombre de tu empresa" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="ruc">RUC <span class="text-danger">*</span></label>
                    <div class="input-group auth-input-group">
                        <input type="text" class="form-control" id="ruc" name="ruc" value="{{ old('ruc') }}" placeholder="12345678901" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="telefono">Teléfono <span class="text-danger">*</span></label>
                    <div class="input-group auth-input-group">
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="999 999 999" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <div class="input-group auth-input-group">
                        <span class="input-group-text">@</span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Contraseña</label>
                    <div class="input-group auth-input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Mostrar contraseña" aria-pressed="false">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                    <div class="input-group auth-input-group">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        <button type="button" class="password-toggle" data-password-toggle="password_confirmation" aria-label="Mostrar contraseña" aria-pressed="false">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary auth-submit">Crear cuenta</button>
            </form>

            <div class="auth-divider">O REGÍSTRATE CON</div>

            <div class="auth-socials auth-socials-single">
                <a href="{{ route('google.redirect') }}" class="btn btn-social btn-google">
                    <svg class="social-icon google-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path fill="#4285F4" d="M21.6 12.23c0-.72-.06-1.42-.18-2.09H12v3.96h5.38a4.6 4.6 0 0 1-1.99 3.02v2.51h3.22c1.89-1.74 2.99-4.3 2.99-7.4Z"/>
                        <path fill="#34A853" d="M12 22c2.7 0 4.97-.9 6.62-2.37l-3.22-2.51c-.9.6-2.05.96-3.4.96-2.61 0-4.82-1.76-5.62-4.13H3.05v2.59A10 10 0 0 0 12 22Z"/>
                        <path fill="#FBBC05" d="M6.38 13.95a6.01 6.01 0 0 1 0-3.9V7.46H3.05a10 10 0 0 0 0 9.08l3.33-2.59Z"/>
                        <path fill="#EA4335" d="M12 5.92c1.47 0 2.79.5 3.83 1.5l2.87-2.87C16.97 2.98 14.7 2 12 2a10 10 0 0 0-8.95 5.46l3.33 2.59C7.18 7.68 9.39 5.92 12 5.92Z"/>
                    </svg>
                    <span>Continuar con Google</span>
                </a>
            </div>

            <div class="auth-footer">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>