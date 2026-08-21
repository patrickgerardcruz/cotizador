<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
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

<div class="container" style="max-width: 1100px;">

    <div class="d-flex justify-content-between align-items-end pt-5 pb-4 flex-wrap gap-3">
        <div>
            <div class="eyebrow mb-2">Cotizador</div>
            <h1 class="display-heading mb-0" style="font-size: 2.4rem;">Servicios</h1>
        </div>
        <a href="{{ route('servicios.create') }}" class="btn btn-primary">
            + Nuevo servicio
        </a>
    </div>

    <hr class="hr-thin mt-0">

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($servicios->count() > 0)

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-end">Precio</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($servicios as $servicio)
                        <tr>
                            <td class="text-muted">{{ $servicio->id }}</td>
                            <td class="fw-medium">{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->descripcion ?? '—' }}</td>
                            <td class="text-end">S/ {{ number_format($servicio->precio, 2) }}</td>

                            <td>
                                @if($servicio->estado)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-neutral">Inactivo</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <a href="{{ route('servicios.show', $servicio->id) }}" class="btn btn-link p-0">
                                        Ver
                                    </a>

                                    <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-link p-0">
                                        Editar
                                    </a>

                                    <form action="{{ route('servicios.destroy', $servicio->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-link p-0 text-danger"
                                                onclick="return confirm('¿Eliminar este servicio?')">
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

        <p class="text-muted py-5">No hay servicios registrados.</p>

    @endif

</div>

</body>
</html>