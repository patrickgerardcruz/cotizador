<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones — PixelCode</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<nav class="navbar navbar-expand px-4 py-3">
    <a class="navbar-brand" href="{{ route('clientes.index') }}">Cotizador</a>
    <div class="d-flex gap-0">
        <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">Clientes</a>
        <a class="nav-link {{ request()->routeIs('cotizaciones.*') ? 'active' : '' }}" href="{{ route('cotizaciones.index') }}">Cotizaciones</a>
        <a class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}" href="{{ route('servicios.index') }}">Servicios</a>
        <a class="nav-link" href="{{ route('home') }}">Ver sitio</a>
        <form method="POST" action="{{ route('logout') }}" class="ms-2 d-inline">
            @csrf
            <button type="submit" class="btn btn-link btn-sm">Salir</button>
        </form>
    </div>
</nav>

<div class="container" style="max-width: 1200px;">

    <div class="d-flex justify-content-between align-items-end pt-5 pb-4 flex-wrap gap-3">
        <div>
            <div class="eyebrow mb-2">Cotizador</div>
            <h1 class="display-heading mb-0" style="font-size: 2.4rem;">Cotizaciones</h1>
        </div>
        <a href="{{ route('cotizaciones.create') }}" class="btn btn-primary">
            + Nueva cotización
        </a>
    </div>

    <hr class="hr-thin mt-0">

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($cotizaciones->count() > 0)

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Subtotal</th>
                        <th>IGV</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($cotizaciones as $cotizacion)
                        <tr>
                            <td class="fw-medium">{{ $cotizacion->numero }}</td>

                            <td>{{ $cotizacion->cliente->nombre }}</td>

                            <td>{{ \Illuminate\Support\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}</td>

                            <td>S/ {{ number_format($cotizacion->subtotal, 2) }}</td>

                            <td>S/ {{ number_format($cotizacion->igv, 2) }}</td>

                            <td class="fw-medium">S/ {{ number_format($cotizacion->total, 2) }}</td>

                            <td>
                                @php
                                    $estadoClase = match(strtolower($cotizacion->estado)) {
                                        'entregado' => 'badge-success',
                                        'en proceso' => 'badge-warning',
                                        default => 'badge-neutral',
                                    };
                                @endphp
                                <span class="badge {{ $estadoClase }}">
                                    {{ ucfirst($cotizacion->estado) }}
                                </span>
                            </td>

                            <td class="text-end">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <a href="{{ route('cotizaciones.show', $cotizacion) }}" class="btn btn-link p-0">
                                        Ver
                                    </a>

                                    <a href="{{ route('cotizaciones.edit', $cotizacion) }}" class="btn btn-link p-0">
                                        Editar
                                    </a>

                                    <form action="{{ route('cotizaciones.destroy', $cotizacion) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-link p-0 text-danger"
                                                onclick="return confirm('¿Eliminar esta cotización?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else

        <p class="text-muted py-5">No hay cotizaciones registradas.</p>

    @endif

</div>

</body>
</html>