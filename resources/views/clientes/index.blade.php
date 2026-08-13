<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
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

<div class="container" style="max-width: 1100px;">

    <div class="d-flex justify-content-between align-items-end pt-5 pb-4 flex-wrap gap-3">
        <div>
            <div class="eyebrow mb-2">Cotizador</div>
            <h1 class="display-heading mb-0" style="font-size: 2.4rem;">Clientes</h1>
        </div>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            + Nuevo cliente
        </a>
    </div>

    <hr class="hr-thin mt-0">

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($clientes->count() > 0)

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Empresa</th>
                        <th>RUC</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td class="text-muted">{{ $cliente->id }}</td>
                            <td class="fw-medium">{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->empresa ?? '—' }}</td>
                            <td>{{ $cliente->ruc ?? '—' }}</td>
                            <td>{{ $cliente->telefono ?? '—' }}</td>
                            <td>{{ $cliente->email ?? '—' }}</td>

                            <td class="text-end">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-link p-0">
                                        Ver
                                    </a>

                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-link p-0">
                                        Editar
                                    </a>

                                    <form action="{{ route('clientes.destroy', $cliente->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-link p-0 text-danger"
                                                onclick="return confirm('¿Eliminar este cliente?')">
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

        <p class="text-muted py-5">No hay clientes registrados.</p>

    @endif

</div>

</body>
</html>