<nav class="navbar navbar-expand px-4 py-3">
    <a class="navbar-brand brand-lockup" href="{{ route('home') }}" aria-label="Pixel Code - Inicio">
        <span class="brand-symbol" aria-hidden="true"><span>&lt;</span><span>/</span><span>&gt;</span></span>
        <span class="brand-name">Pixel Code</span>
    </a>
    <div class="d-flex align-items-center gap-0 ms-auto">
        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
        <a class="nav-link {{ request()->routeIs('servicios.publico') ? 'active' : '' }}" href="{{ route('servicios.publico') }}">Servicios</a>
        <a class="nav-link {{ request()->routeIs('contacto') ? 'active' : '' }}" href="{{ route('contacto') }}">Contacto</a>

        @auth
            <a class="nav-link {{ request()->routeIs('mis-cotizaciones.*') ? 'active' : '' }}" href="{{ route('mis-cotizaciones.index') }}">Mis cotizaciones</a>
            @if(!auth()->user()->isAdmin())
                <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Mi perfil</a>
            @endif
            @if(auth()->user()->isAdmin())
                <a class="nav-link" href="{{ route('clientes.index') }}">Panel admin</a>
            @endif
            <a class="btn btn-primary btn-sm ms-3" href="{{ route('cotizar.create') }}">Pedir cotización</a>
            <form method="POST" action="{{ route('logout') }}" class="ms-2">
                @csrf
                <button type="submit" class="btn btn-link btn-sm">Salir</button>
            </form>
        @else
            <a class="nav-link" href="{{ route('login') }}">Ingresar</a>
            <a class="btn btn-primary btn-sm ms-3" href="{{ route('register') }}">Registrarme</a>
        @endauth
    </div>
</nav>