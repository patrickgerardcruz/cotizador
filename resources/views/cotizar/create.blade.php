<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar cotización — Pixel Code</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('partials.nav')

<div class="container" style="max-width: 800px;">
    <div class="pt-5 pb-4">
        <div class="eyebrow mb-2">Nueva solicitud</div>
        <h1 class="display-heading mb-0" style="font-size: 2.2rem;">Arma tu cotización</h1>
        <p class="mt-2" style="color: var(--ink-soft);">Selecciona los servicios que necesitas y ajusta la cantidad.</p>
    </div>

    <hr class="hr-thin mt-0">

    @if ($errors->any())
        <div class="alert mb-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($servicios->count() === 0)
        <p style="color: var(--ink-soft);">Aún no hay servicios disponibles para cotizar.</p>
    @else
        <form method="POST" action="{{ route('cotizar.store') }}" id="form-cotizacion">
            @csrf

            @foreach($servicios as $servicio)
                <div class="service-item">
                    <div class="service-main">
                        <input
                            class="form-check-input servicio-check"
                            type="checkbox"
                            data-index="{{ $loop->index }}"
                            id="check-{{ $servicio->id }}"
                        >
                        @if($servicio->imagenes->isNotEmpty())
                            @php
                                $galeria = $servicio->imagenes->map(fn ($imagen) => [
                                    'src' => Storage::disk('public')->url($imagen->ruta),
                                    'alt' => 'Ejemplo de ' . $servicio->nombre,
                                ])->values();
                                $primeraImagen = $galeria->first();
                            @endphp
                            <div class="service-example-thumb-wrap">
                                <img class="service-example-thumb" src="{{ $primeraImagen['src'] }}" alt="{{ $primeraImagen['alt'] }}" data-image-preview data-image-preview-gallery="{{ $galeria->toJson() }}">
                                <button type="button" class="image-preview-trigger image-preview-trigger-small" data-image-preview data-image-preview-gallery="{{ $galeria->toJson() }}" aria-label="Ver todas las imágenes" title="Ver todas las imágenes">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                                </button>
                            </div>
                        @endif
                        <div>
                            <label class="service-name" for="check-{{ $servicio->id }}">{{ $servicio->nombre }}</label>
                            @if($servicio->descripcion)
                                <div style="color: var(--ink-soft); font-size: 0.85rem;">{{ $servicio->descripcion }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <input
                            type="number"
                            class="service-qty"
                            value="1"
                            min="1"
                            disabled
                            data-index="{{ $loop->index }}"
                            data-precio="{{ $servicio->precio }}"
                        >
                        <div class="service-price">S/ {{ number_format($servicio->precio, 2) }}</div>
                    </div>
                    <input type="hidden" class="servicio-id-input" data-index="{{ $loop->index }}" name="" value="{{ $servicio->id }}">
                </div>
            @endforeach

            <div class="mt-4 pt-3" style="border-top: 1.5px solid var(--ink);">
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: var(--ink-soft);">Subtotal estimado</span>
                    <span id="resumen-subtotal">S/ 0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: var(--ink-soft);">IGV (18%)</span>
                    <span id="resumen-igv">S/ 0.00</span>
                </div>
                <div class="d-flex justify-content-between fw-medium" style="font-size: 1.1rem;">
                    <span>Total estimado</span>
                    <span id="resumen-total">S/ 0.00</span>
                </div>
            </div>

            <div class="mt-4">
                <label class="form-label" for="observaciones">Cuéntanos más sobre tu proyecto (opcional)</label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="4">{{ old('observaciones') }}</textarea>
            </div>

            <div id="inputs-servicios"></div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary w-100" id="btn-enviar" disabled>
                    Enviar solicitud de cotización
                </button>
                <p class="text-center mt-2" style="color: var(--ink-soft); font-size: 0.85rem;">
                    Selecciona al menos un servicio para continuar.
                </p>
            </div>
        </form>
    @endif
</div>

@include('partials.image-preview-modal')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checks = document.querySelectorAll('.servicio-check');
    const inputsContainer = document.getElementById('inputs-servicios');
    const btnEnviar = document.getElementById('btn-enviar');

    function actualizarResumen() {
        let subtotal = 0;
        inputsContainer.innerHTML = '';

        checks.forEach(function (check) {
            const index = check.dataset.index;
            const qtyInput = document.querySelector('.service-qty[data-index="' + index + '"]');
            const idInput = document.querySelector('.servicio-id-input[data-index="' + index + '"]');

            qtyInput.disabled = !check.checked;

            if (check.checked) {
                const cantidad = parseInt(qtyInput.value) || 1;
                const precio = parseFloat(qtyInput.dataset.precio);
                subtotal += cantidad * precio;

                const hiddenId = document.createElement('input');
                hiddenId.type = 'hidden';
                hiddenId.name = 'servicios[' + index + '][servicio_id]';
                hiddenId.value = idInput.value;
                inputsContainer.appendChild(hiddenId);

                const hiddenQty = document.createElement('input');
                hiddenQty.type = 'hidden';
                hiddenQty.name = 'servicios[' + index + '][cantidad]';
                hiddenQty.value = cantidad;
                inputsContainer.appendChild(hiddenQty);
            }
        });

        const igv = subtotal * 0.18;
        const total = subtotal + igv;

        document.getElementById('resumen-subtotal').textContent = 'S/ ' + subtotal.toFixed(2);
        document.getElementById('resumen-igv').textContent = 'S/ ' + igv.toFixed(2);
        document.getElementById('resumen-total').textContent = 'S/ ' + total.toFixed(2);

        const algunoSeleccionado = Array.from(checks).some(c => c.checked);
        btnEnviar.disabled = !algunoSeleccionado;
    }

    checks.forEach(function (check) {
        check.addEventListener('change', actualizarResumen);
    });

    document.querySelectorAll('.service-qty').forEach(function (qty) {
        qty.addEventListener('input', actualizarResumen);
    });

    actualizarResumen();
});
</script>

</body>
</html>