<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis cotizaciones — PixelCode</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('partials.nav')

<div class="container" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-end pt-5 pb-4 flex-wrap gap-3">
        <div>
            <div class="eyebrow mb-2">Tu historial</div>
            <h1 class="display-heading mb-0" style="font-size: 2.2rem;">Mis cotizaciones</h1>
        </div>
        <a href="{{ route('cotizar.create') }}" class="btn btn-primary">+ Nueva cotización</a>
    </div>

    <hr class="hr-thin mt-0">

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if($cotizaciones->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotizaciones as $cotizacion)
                    <tr>
                        <td class="fw-medium">{{ $cotizacion->numero }}</td>
                        <td>{{ \Carbon\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}</td>
                        <td>S/ {{ number_format($cotizacion->total, 2) }}</td>
                        <td>
                                <span class="badge badge-{{ $cotizacion->estado === 'entregado' ? 'success' : ($cotizacion->estado === 'en proceso' ? 'warning' : 'neutral') }}">
                                {{ ucfirst($cotizacion->estado) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('mis-cotizaciones.show', $cotizacion) }}" class="btn-link">Ver detalle</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: var(--ink-soft);">Todavía no has solicitado ninguna cotización.</p>
        <a href="{{ route('cotizar.create') }}" class="btn btn-primary mt-2">Solicitar mi primera cotización</a>
    @endif
</div>

</body>
</html>