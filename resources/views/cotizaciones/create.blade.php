<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Cotización</title>
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
    <h1 class="display-heading mb-5" style="font-size: 2.2rem;">Nueva cotización</h1>

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

    <form action="{{ route('cotizaciones.store') }}" method="POST">
        @csrf

        <div class="eyebrow mb-3" style="font-size: 0.72rem;">01 · Cliente</div>

        <div class="mb-4">
            <label class="form-label">Cliente</label>
            <select name="cliente_id" class="form-select" required>
                <option value="">Seleccione un cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">
                        {{ $cliente->nombre }}
                        @if($cliente->empresa)
                            — {{ $cliente->empresa }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-sm-6 mb-4">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" value="{{ date('Y-m-d') }}" class="form-control" required>
            </div>
            <div class="col-sm-6 mb-4">
                <label class="form-label">Validez</label>
                <input type="date" name="validez" class="form-control">
            </div>
        </div>

        <hr class="hr-thin">

        <div class="eyebrow mb-1" style="font-size: 0.72rem;">02 · Servicios</div>
        <p class="text-muted mb-3" style="font-size: 0.88rem;">Selecciona los servicios a incluir y su cantidad.</p>

        <div class="mb-4">
            @foreach($servicios as $servicio)
                <div class="service-item">
                    <div class="service-main">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            name="servicios[{{ $loop->index }}][servicio_id]"
                            value="{{ $servicio->id }}"
                            id="servicio_{{ $loop->index }}"
                            onchange="activarCantidad({{ $loop->index }})"
                        >
                        <label for="servicio_{{ $loop->index }}" class="service-name">
                            {{ $servicio->nombre }}
                        </label>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <span class="service-price">S/ {{ number_format($servicio->precio, 2) }}</span>
                        <input
                            type="number"
                            id="cantidad_{{ $loop->index }}"
                            name="servicios[{{ $loop->index }}][cantidad]"
                            value="1"
                            min="1"
                            disabled
                            class="service-qty"
                        >
                    </div>
                </div>
            @endforeach
        </div>

        <hr class="hr-thin">

        <div class="eyebrow mb-3" style="font-size: 0.72rem;">03 · Observaciones</div>

        <div class="mb-5">
            <textarea
                name="observaciones"
                rows="4"
                class="form-control"
                style="border: 1.5px solid var(--line); border-radius: 4px; padding: 0.75rem;"
                placeholder="Observaciones de la cotización..."
            ></textarea>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                Crear cotización
            </button>
            <a href="{{ route('cotizaciones.index') }}" class="btn btn-link">
                Cancelar
            </a>
        </div>

    </form>

</div>

<script>
function activarCantidad(index) {
    const checkbox = document.querySelector(
        'input[name="servicios[' + index + '][servicio_id]"]'
    );
    const cantidad = document.getElementById('cantidad_' + index);
    cantidad.disabled = !checkbox.checked;
}
</script>

</body>
</html>