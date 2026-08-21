<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cotizacion->numero }} — Pixel Code</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('partials.nav')

<div class="container" style="max-width: 800px;">
    <div class="pt-5 pb-4">
        <a href="{{ route('mis-cotizaciones.index') }}" class="btn-link">← Volver a mis cotizaciones</a>
        <div class="d-flex justify-content-between align-items-start mt-3 flex-wrap gap-3">
            <div>
                <div class="eyebrow mb-2">Cotización</div>
                <h1 class="display-heading mb-0" style="font-size: 2rem;">{{ $cotizacion->numero }}</h1>
            </div>
            <span class="badge badge-{{ $cotizacion->estado === 'entregado' ? 'success' : ($cotizacion->estado === 'en proceso' ? 'warning' : 'neutral') }}">
                {{ ucfirst($cotizacion->estado) }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <hr class="hr-thin mt-0">

    <div class="d-flex gap-5 mb-4 flex-wrap">
        <div>
            <div class="form-label mb-1">Fecha</div>
            <div>{{ \Carbon\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}</div>
        </div>
        <div>
            <div class="form-label mb-1">Válida hasta</div>
            <div>{{ $cotizacion->validez ? \Carbon\Carbon::parse($cotizacion->validez)->format('d/m/Y') : '—' }}</div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Cantidad</th>
                <th>Precio unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cotizacion->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->servicio->nombre ?? 'Servicio eliminado' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>S/ {{ number_format($detalle->precio, 2) }}</td>
                    <td>S/ {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 pt-3" style="border-top: 1.5px solid var(--ink); max-width: 320px; margin-left: auto;">
        <div class="d-flex justify-content-between mb-2">
            <span style="color: var(--ink-soft);">Subtotal</span>
            <span>S/ {{ number_format($cotizacion->subtotal, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span style="color: var(--ink-soft);">IGV (18%)</span>
            <span>S/ {{ number_format($cotizacion->igv, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between fw-medium" style="font-size: 1.1rem;">
            <span>Total</span>
            <span>S/ {{ number_format($cotizacion->total, 2) }}</span>
        </div>
    </div>

    @if($cotizacion->observaciones)
        <div class="mt-4">
            <div class="form-label mb-1">Observaciones</div>
            <p>{{ $cotizacion->observaciones }}</p>
        </div>
    @endif
</div>

</body>
</html>