<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel Code — Desarrollo de software a medida</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('partials.nav')

<div class="container" style="max-width: 1100px;">

    <div class="pt-5 pt-md-5 pb-5 text-center" style="max-width: 720px; margin: 0 auto;">
        <div class="eyebrow mb-3">Agencia de desarrollo de software</div>
        <h1 class="display-heading mb-4" style="font-size: clamp(2.2rem, 5vw, 3.2rem);">
            Construimos el software que tu negocio necesita
        </h1>
        <p class="mb-4" style="color: var(--ink-soft); font-size: 1.1rem;">
            Tiendas virtuales, sistemas a medida y e-commerce. Cuéntanos tu proyecto y arma tu propia cotización en minutos.
        </p>
        <a href="{{ route('cotizar.create') }}" class="btn btn-primary">Solicitar cotización</a>
        <a href="{{ route('servicios.publico') }}" class="btn btn-link">Ver servicios</a>
    </div>

    <hr class="hr-thin">

    <div class="pb-5">
        <div class="eyebrow mb-2">Lo que hacemos</div>
        <h2 class="display-heading mb-4" style="font-size: 1.8rem;">Servicios destacados</h2>

        @if($servicios->count() > 0)
            <div class="row g-4">
                @foreach($servicios as $servicio)
                    <div class="col-md-4">
                        <div class="p-4 h-100" style="border: 1px solid var(--line); border-radius: 6px;">
                            @if($servicio->imagenes->isNotEmpty())
                                @php
                                    $galeria = $servicio->imagenes->map(fn ($imagen) => [
                                        'src' => Storage::disk('public')->url($imagen->ruta),
                                        'alt' => 'Ejemplo de ' . $servicio->nombre,
                                    ])->values();
                                    $primeraImagen = $galeria->first();
                                @endphp
                                <div class="service-card-image-wrap">
                                    <img class="service-card-image" src="{{ $primeraImagen['src'] }}" alt="{{ $primeraImagen['alt'] }}" data-image-preview data-image-preview-gallery="{{ $galeria->toJson() }}">
                                    <button type="button" class="image-preview-trigger" data-image-preview data-image-preview-gallery="{{ $galeria->toJson() }}" aria-label="Ver todas las imágenes" title="Ver todas las imágenes">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-5 9.5-5 9.5 5 9.5 5-3.5 5-9.5 5-9.5-5-9.5-5Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                                    </button>
                                </div>
                            @endif
                            <div class="fw-medium mb-2" style="font-size: 1.05rem;">{{ $servicio->nombre }}</div>
                            <p class="mb-3" style="color: var(--ink-soft); font-size: 0.92rem;">
                                {{ $servicio->descripcion ?? 'Consulta por este servicio.' }}
                            </p>
                            <div class="service-price">Desde S/ {{ number_format($servicio->precio, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                <a href="{{ route('servicios.publico') }}" class="btn btn-outline-secondary">Ver todos los servicios</a>
            </div>
        @else
            <p style="color: var(--ink-soft);">Pronto publicaremos nuestro catálogo de servicios.</p>
        @endif
    </div>

    <hr class="hr-thin">

    <div class="pb-5 text-center">
        <h2 class="display-heading mb-3" style="font-size: 1.6rem;">¿Listo para empezar tu proyecto?</h2>
        <p class="mb-4" style="color: var(--ink-soft);">Regístrate y arma tu cotización eligiendo los servicios que necesitas.</p>
        @auth
            <a href="{{ route('cotizar.create') }}" class="btn btn-primary">Pedir cotización</a>
        @else
            <a href="{{ route('register') }}" class="btn btn-primary">Crear cuenta gratis</a>
        @endauth
    </div>

</div>

@include('partials.image-preview-modal')
@include('partials.footer')

</body>
</html>