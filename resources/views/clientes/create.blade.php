<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Cliente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="split-wrap">

    <div class="split-panel">
        <div class="mark">Cotizador</div>
        <div class="quote">
            Cada cliente nuevo es el inicio de una propuesta a medida.
        </div>
        <div class="foot-note">Ficha de registro · Clientes</div>
    </div>

    <div class="split-form">

        <div class="eyebrow mb-2">Nuevo registro</div>
        <h1 class="display-heading mb-5" style="font-size: 2.1rem;">Datos del cliente</h1>

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clientes.store') }}" method="POST">

            @csrf

            <div class="q-field">
                <div class="q-num">01</div>
                <div class="q-input-wrap">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control">
                </div>
            </div>

            <div class="q-field">
                <div class="q-num">02</div>
                <div class="q-input-wrap">
                    <label class="form-label">Empresa</label>
                    <input type="text" name="empresa" value="{{ old('empresa') }}" class="form-control">
                </div>
            </div>

            <div class="q-field">
                <div class="q-num">03</div>
                <div class="q-input-wrap">
                    <label class="form-label">RUC</label>
                    <input type="text" name="ruc" value="{{ old('ruc') }}" class="form-control">
                </div>
            </div>

            <div class="q-field">
                <div class="q-num">04</div>
                <div class="q-input-wrap">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control">
                </div>
            </div>

            <div class="q-field">
                <div class="q-num">05</div>
                <div class="q-input-wrap">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                </div>
            </div>

            <div class="q-field" style="border-bottom: none;">
                <div class="q-num">06</div>
                <div class="q-input-wrap">
                    <label class="form-label">Dirección</label>
                    <textarea name="direccion" class="form-control" rows="2" style="border: none; border-bottom: 1px solid var(--line); border-radius:0; padding: 0.2rem 0;">{{ old('direccion') }}</textarea>
                </div>
            </div>

            <div class="q-field">
                <div class="q-num">07</div>
                <div class="q-input-wrap">
                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" minlength="8" required>
                </div>
            </div>

            <div class="q-field" style="border-bottom: none;">
                <div class="q-num">08</div>
                <div class="q-input-wrap">
                    <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" minlength="8" required>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mt-5">
                <button type="submit" class="btn btn-primary">
                    Guardar cliente
                </button>
                <a href="{{ route('clientes.index') }}" class="btn btn-link">
                    Cancelar
                </a>
            </div>

        </form>

    </div>

</div>

</body>
</html>