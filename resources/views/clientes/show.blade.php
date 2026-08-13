<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Cliente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="container" style="max-width: 780px;">

    <div class="pt-5 pb-4">
        <div class="eyebrow mb-2">Cliente #{{ $cliente->id }}</div>
        <h1 class="display-heading mb-0" style="font-size: 2.4rem;">{{ $cliente->nombre }}</h1>
        @if($cliente->empresa)
            <p class="text-muted mt-2 mb-0">{{ $cliente->empresa }}</p>
        @endif
    </div>

    <hr class="hr-thin">

    <div class="row gy-4">
        <div class="col-sm-6">
            <div class="eyebrow mb-1" style="font-size: 0.72rem;">RUC</div>
            <div style="font-size: 1.05rem;">{{ $cliente->ruc ?? '—' }}</div>
        </div>

        <div class="col-sm-6">
            <div class="eyebrow mb-1" style="font-size: 0.72rem;">Teléfono</div>
            <div style="font-size: 1.05rem;">{{ $cliente->telefono ?? '—' }}</div>
        </div>

        <div class="col-sm-6">
            <div class="eyebrow mb-1" style="font-size: 0.72rem;">Email</div>
            <div style="font-size: 1.05rem;">{{ $cliente->email ?? '—' }}</div>
        </div>

        <div class="col-sm-6">
            <div class="eyebrow mb-1" style="font-size: 0.72rem;">Dirección</div>
            <div style="font-size: 1.05rem;">{{ $cliente->direccion ?? '—' }}</div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 mt-5 pb-5">
        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-primary">
            Editar cliente
        </a>
        <a href="{{ route('clientes.index') }}" class="btn btn-link">
            Volver a clientes
        </a>
    </div>

</div>

</body>
</html>