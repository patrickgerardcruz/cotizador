<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completa tu perfil - PixelCode</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-body">

<div class="auth-shell">
    <div class="auth-visual">
        <div class="auth-brand">
            <span class="brand-mark"><span class="brand-angle">&lt;</span><span class="brand-slash">/</span><span class="brand-angle">&gt;</span></span>
            <span class="brand-word">PixelCode</span>
        </div>

        <h1 class="auth-hero-title">Un último paso para comenzar.</h1>
        <p class="auth-hero-copy">
            Completa los datos de tu empresa para preparar tus cotizaciones de forma rápida y precisa.
        </p>
    </div>

    <div class="auth-form-panel">
        <div class="auth-form-box">
            <h2>Completa tu perfil</h2>
            <p class="auth-subtitle">Necesitamos estos datos para continuar.</p>

            @if ($errors->any())
                <div class="alert custom-alert mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.complete') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="empresa">Empresa <span class="text-danger">*</span></label>
                    <div class="input-group auth-input-group">
                        <input type="text" class="form-control" id="empresa" name="empresa" value="{{ old('empresa', $cliente?->empresa) }}" placeholder="Nombre de tu empresa" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="ruc">RUC <span class="text-danger">*</span></label>
                    <div class="input-group auth-input-group">
                        <input type="text" class="form-control" id="ruc" name="ruc" value="{{ old('ruc', $cliente?->ruc) }}" placeholder="12345678901" inputmode="numeric" maxlength="11" pattern="[0-9]{11}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="telefono">Teléfono <span class="text-danger">*</span></label>
                    <div class="input-group auth-input-group">
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $cliente?->telefono) }}" placeholder="999 999 999" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary auth-submit">Continuar</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
