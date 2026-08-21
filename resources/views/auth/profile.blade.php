<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil - PixelCode</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('partials.nav')

<div class="container py-5" style="max-width: 640px;">
    <div class="eyebrow mb-2">Cuenta</div>
    <h1 class="display-heading mb-2" style="font-size: 2.4rem;">Mi perfil</h1>
    <p class="text-muted mb-5">Actualiza tu teléfono y correo electrónico.</p>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label" for="nombre">Nombre completo</label>
            <input type="text" class="form-control" id="nombre" value="{{ auth()->user()->name }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label" for="empresa">Empresa</label>
            <input type="text" class="form-control" id="empresa" value="{{ $cliente?->empresa ?? '—' }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label" for="ruc">RUC</label>
            <input type="text" class="form-control" id="ruc" value="{{ $cliente?->ruc ?? '—' }}" readonly>
        </div>

        <div class="mb-4">
            <label class="form-label" for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" value="{{ $cliente?->direccion ?? '—' }}" readonly>
        </div>

        <div class="mb-4">
            <label class="form-label" for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $cliente?->telefono) }}" required>
        </div>

        <div class="mb-4">
            <label class="form-label" for="email">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('home') }}" class="btn btn-link">Cancelar</a>
        </div>
    </form>
</div>

</body>
</html>
