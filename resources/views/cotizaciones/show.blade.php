<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización {{ $cotizacion->numero }}</title>
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

<div class="container py-5" style="max-width: 860px;">

    <a href="{{ route('cotizaciones.index') }}" class="btn btn-link p-0 mb-4">
        &larr; Volver a cotizaciones
    </a>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <div class="eyebrow mb-2">Cotización</div>
            <h1 class="display-heading mb-0" style="font-size: 2.3rem;">{{ $cotizacion->numero }}</h1>
        </div>
        <div>
            @php
                $estadoClase = match(strtolower($cotizacion->estado)) {
                    'aprobada', 'aprobado' => 'badge-success',
                    'rechazada', 'rechazado', 'anulada' => 'badge-danger',
                    default => 'badge-neutral',
                };
            @endphp
            <span class="badge {{ $estadoClase }}" style="font-size: 0.85rem;">
                {{ ucfirst($cotizacion->estado) }}
            </span>
        </div>
    </div>

    <hr class="hr-thin mt-0">

    <div class="row gy-4 mb-2">
        <div class="col-sm-4">
            <div class="eyebrow mb-1" style="font-size: 0.72rem;">Cliente</div>
            <div style="font-size: 1.05rem;">{{ $cotizacion->cliente?->nombre ?? 'Cliente no encontrado' }}</div>
        </div>
        <div class="col-sm-4">
            <div class="eyebrow mb-1" style="font-size: 0.72rem;">Fecha</div>
            <div style="font-size: 1.05rem;">{{ \Illuminate\Support\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}</div>
        </div>
        <div class="col-sm-4">
            <div class="eyebrow mb-1" style="font-size: 0.72rem;">Validez</div>
            <div style="font-size: 1.05rem;">
                {{ $cotizacion->validez ? \Illuminate\Support\Carbon::parse($cotizacion->validez)->format('d/m/Y') : '—' }}
            </div>
        </div>

        @if($cotizacion->observaciones)
            <div class="col-12">
                <div class="eyebrow mb-1" style="font-size: 0.72rem;">Observaciones</div>
                <div style="font-size: 1.02rem;">{{ $cotizacion->observaciones }}</div>
            </div>
        @endif
    </div>

    <hr class="hr-thin">

    <div class="eyebrow mb-3" style="font-size: 0.72rem;">Servicios</div>

    @if($cotizacion->detalles->count() > 0)

        <div class="table-responsive mb-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th class="text-end">Cantidad</th>
                        <th class="text-end">Precio</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($cotizacion->detalles as $detalle)
                        <tr>
                            <td class="fw-medium">{{ $detalle->servicio?->nombre ?? 'Servicio no encontrado' }}</td>
                            <td class="text-end">{{ $detalle->cantidad }}</td>
                            <td class="text-end">S/ {{ number_format($detalle->precio, 2) }}</td>
                            <td class="text-end">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else

        <p class="text-muted">Esta cotización no tiene servicios registrados.</p>

    @endif

    <div class="d-flex justify-content-end">
        <div style="min-width: 280px;">
            <div class="d-flex justify-content-between py-2">
                <span class="text-muted">Subtotal</span>
                <span>S/ {{ number_format($cotizacion->subtotal, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between py-2">
                <span class="text-muted">Descuento</span>
                <span>S/ {{ number_format($cotizacion->descuento, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between py-2">
                <span class="text-muted">IGV</span>
                <span>S/ {{ number_format($cotizacion->igv, 2) }}</span>
            </div>
            <hr class="hr-thin my-2">
            <div class="d-flex justify-content-between py-2">
                <span class="fw-medium" style="font-size: 1.1rem;">Total</span>
                <span class="fw-medium" style="font-size: 1.1rem;">S/ {{ number_format($cotizacion->total, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="mt-5 pb-5">
        <a href="{{ route('cotizaciones.edit', $cotizacion) }}" class="btn btn-primary">
            Editar cotización
        </a>
    </div>

</div>

</body>
</html>