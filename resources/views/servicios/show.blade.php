<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Servicio</title>
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

<div class="container" style="max-width: 780px;">

    <div class="pt-5 pb-4">
        <div class="eyebrow mb-2">Servicio #{{ $servicio->id }}</div>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <h1 class="display-heading mb-0" style="font-size: 2.4rem;">{{ $servicio->nombre }}</h1>
            @if($servicio->estado)
                <span class="badge badge-success">Activo</span>
            @else
                <span class="badge badge-neutral">Inactivo</span>
            @endif
        </div>
    </div>

    <hr class="hr-thin">

    <div class="row gy-4">
        <div class="col-sm-6">
            <div class="eyebrow mb-1" style="font-size: 0.72rem;">Precio</div>
            <div style="font-size: 1.05rem;">S/ {{ number_format($servicio->precio, 2) }}</div>
        </div>

        <div class="col-12">
            <div class="eyebrow mb-1" style="font-size: 0.72rem;">Descripción</div>
            <div style="font-size: 1.05rem;">{{ $servicio->descripcion ?? '—' }}</div>
        </div>
    </div>

    @if($servicio->imagenes->isNotEmpty())
        <div class="mt-5">
            <div class="eyebrow mb-3" style="font-size: 0.72rem;">Ejemplos de diseño</div>
            <div class="service-gallery">
                @foreach($servicio->imagenes as $imagen)
                    <img src="{{ Storage::disk('public')->url($imagen->ruta) }}" alt="Ejemplo de {{ $servicio->nombre }}">
                @endforeach
            </div>
        </div>
    @endif

    <div class="d-flex align-items-center gap-3 mt-5 pb-5">
        <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-primary">
            Editar servicio
        </a>
        <a href="{{ route('servicios.index') }}" class="btn btn-link">
            Volver a servicios
        </a>
    </div>

</div>

</body>
</html>