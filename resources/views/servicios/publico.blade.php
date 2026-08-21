<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios — PixelCode</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('partials.nav')

<div class="container" style="max-width: 900px;">
    <div class="pt-5 pb-4">
        <div class="eyebrow mb-2">Catálogo</div>
        <h1 class="display-heading mb-0" style="font-size: 2.4rem;">Nuestros servicios</h1>
    </div>

    <hr class="hr-thin mt-0">

    @if($servicios->count() > 0)
        @foreach($servicios as $servicio)
            <div class="service-item">
                @if($servicio->imagenes->isNotEmpty())
                    @php
                        $galeria = $servicio->imagenes->map(fn ($imagen) => [
                            'src' => Storage::disk('public')->url($imagen->ruta),
                            'alt' => 'Ejemplo de ' . $servicio->nombre,
                        ])->values();
                        $primeraImagen = $galeria->first();
                    @endphp
                    <div class="service-gallery service-gallery-preview">
                        <div class="service-gallery-item">
                            <img src="{{ $primeraImagen['src'] }}" alt="{{ $primeraImagen['alt'] }}" data-image-preview data-image-preview-gallery="{{ $galeria->toJson() }}">
                            <button type="button" class="image-preview-trigger" data-image-preview data-image-preview-gallery="{{ $galeria->toJson() }}" aria-label="Ver todas las imágenes" title="Ver todas las imágenes">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="service-main">
                    <div>
                        <div class="service-name">{{ $servicio->nombre }}</div>
                        @if($servicio->descripcion)
                            <div style="color: var(--ink-soft); font-size: 0.88rem;">{{ $servicio->descripcion }}</div>
                        @endif
                    </div>
                </div>
                <div class="service-price">S/ {{ number_format($servicio->precio, 2) }}</div>
            </div>
        @endforeach

        <div class="mt-5 text-center">
            <a href="{{ route('cotizar.create') }}" class="btn btn-primary">Solicitar cotización con estos servicios</a>
        </div>
    @else
        <p style="color: var(--ink-soft);">Aún no hay servicios publicados.</p>
    @endif
</div>

@include('partials.image-preview-modal')
@include('partials.footer')

</body>
</html>