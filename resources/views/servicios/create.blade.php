<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Servicio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<nav class="navbar navbar-expand px-4 py-3">
    <a class="navbar-brand" href="{{ route('clientes.index') }}">Cotizador</a>
    <div class="d-flex gap-0">
        <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">Clientes</a>
        <a class="nav-link {{ request()->routeIs('cotizaciones.*') ? 'active' : '' }}" href="{{ route('cotizaciones.index') }}">Cotizaciones</a>
        <a class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}" href="{{ route('servicios.index') }}">Servicios</a>
    </div>
</nav>

<div class="container py-5" style="max-width: 640px;">

    <div class="eyebrow mb-2">Servicios</div>
    <h1 class="display-heading mb-5" style="font-size: 2.2rem;">Nuevo servicio</h1>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">

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
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="2" style="border: none; border-bottom: 1px solid var(--line); border-radius:0; padding: 0.2rem 0;">{{ old('descripcion') }}</textarea>
            </div>
        </div>

        <div class="q-field" style="border-bottom: none;">
            <div class="q-num">03</div>
            <div class="q-input-wrap">
                <label class="form-label">Precio (S/)</label>
                <input type="number" name="precio" step="0.01" min="0" value="{{ old('precio') }}" class="form-control">
            </div>
        </div>

        <div class="q-field" style="border-bottom: none;">
            <div class="q-num">04</div>
            <div class="q-input-wrap">
                <label class="form-label">Fotos de ejemplos</label>
                <input type="file" name="fotos[]" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
                <div class="form-text">Puedes subir hasta 8 imágenes de máximo 5 MB cada una.</div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 mt-5">
            <button type="submit" class="btn btn-primary">
                Guardar servicio
            </button>
            <a href="{{ route('servicios.index') }}" class="btn btn-link">
                Cancelar
            </a>
        </div>

    </form>

</div>

</body>
</html>