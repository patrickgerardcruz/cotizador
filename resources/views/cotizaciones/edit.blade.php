<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cotización</title>
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

<div class="container py-5" style="max-width: 760px;">

    <div class="eyebrow mb-2">Cotizaciones</div>
    <h1 class="display-heading mb-5" style="font-size: 2.2rem;">Editar cotización #{{ $cotizacion->id }}</h1>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <div class="fw-medium mb-1">Hay errores:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{--
        NOTA: verifica que la ruta y el @method coincidan con tu controlador.
        Asumo update por PUT, igual que en clientes.
    --}}
    <form action="{{ route('cotizaciones.update', $cotizacion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="eyebrow mb-3" style="font-size: 0.72rem;">01 · Datos de la cotización</div>

        <div class="row gy-4 mb-4">
            <div class="col-sm-6">
                <div class="eyebrow mb-1" style="font-size: 0.72rem;">Cliente</div>
                <div>{{ $cotizacion->cliente?->nombre ?? 'Cliente no encontrado' }}</div>
            </div>
            <div class="col-sm-6">
                <div class="eyebrow mb-1" style="font-size: 0.72rem;">Empresa</div>
                <div>{{ $cotizacion->cliente?->empresa ?? '—' }}</div>
            </div>
            <div class="col-sm-6">
                <div class="eyebrow mb-1" style="font-size: 0.72rem;">Fecha</div>
                <div>{{ \Illuminate\Support\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}</div>
            </div>
            <div class="col-sm-6">
                <div class="eyebrow mb-1" style="font-size: 0.72rem;">Validez</div>
                <div>{{ $cotizacion->validez ? \Illuminate\Support\Carbon::parse($cotizacion->validez)->format('d/m/Y') : '—' }}</div>
            </div>
        </div>

        <hr class="hr-thin">

        <div class="eyebrow mb-1" style="font-size: 0.72rem;">02 · Servicios</div>
        <p class="text-muted mb-3" style="font-size: 0.88rem;">Estos son los servicios seleccionados por el cliente y no se pueden modificar.</p>

        <div class="table-responsive mb-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th class="text-end">Cantidad</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cotizacion->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->servicio?->nombre ?? 'Servicio no encontrado' }}</td>
                            <td class="text-end">{{ $detalle->cantidad }}</td>
                            <td class="text-end">S/ {{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr class="hr-thin">

        <div class="eyebrow mb-3" style="font-size: 0.72rem;">03 · Detalles y estado</div>

        <div class="mb-4">
            <label class="form-label" for="estado">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="pendiente" {{ old('estado', $cotizacion->estado) === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en proceso" {{ old('estado', $cotizacion->estado) === 'en proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="entregado" {{ old('estado', $cotizacion->estado) === 'entregado' ? 'selected' : '' }}>Entregado</option>
            </select>
        </div>

        <div class="mb-5">
            <label class="form-label" for="observaciones">Detalles / observaciones</label>
            <textarea
                id="observaciones"
                name="observaciones"
                rows="4"
                class="form-control"
                style="border: 1.5px solid var(--line); border-radius: 4px; padding: 0.75rem;"
                placeholder="Observaciones de la cotización..."
            >{{ old('observaciones', $cotizacion->observaciones) }}</textarea>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                Actualizar cotización
            </button>
            <a href="{{ route('cotizaciones.index') }}" class="btn btn-link">
                Cancelar
            </a>
        </div>

    </form>

</div>

</body>
</html>