<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto — Pixel Code</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('partials.nav')

<div class="container" style="max-width: 700px;">
    <div class="pt-5 pb-4">
        <div class="eyebrow mb-2">Hablemos</div>
        <h1 class="display-heading mb-3" style="font-size: 2.2rem;">Contáctanos</h1>
        <p style="color: var(--ink-soft);">
            ¿Tienes un proyecto en mente? La forma más rápida de recibir una propuesta es
            <a href="{{ route('register') }}">crear una cuenta</a> y armar tu propia cotización.
            También puedes escribirnos directamente:
        </p>
    </div>

    <hr class="hr-thin mt-0">

    <ul class="list-unstyled" style="font-size: 1.05rem;">
        <li class="mb-3"><strong>Email:</strong> contacto@nimbussoftware.com</li>
        <li class="mb-3"><strong>Teléfono:</strong> +51 989 971 620</li>
        <li class="mb-3"><strong>Horario:</strong> Lunes a viernes, 9:00 a.m. — 6:00 p.m.</li>
    </ul>
</div>

@include('partials.footer')

</body>
</html>