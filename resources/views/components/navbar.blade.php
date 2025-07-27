<nav class="navbar navbar-expand-md px-17 border-bottom">
    <div class="container-fluid gap-3">
        <a class="navbar-brand" href="#"><img id="logo" class="toggle-image-dark"
                src="{{ asset('assets/img/logo_2.png') }}" width="150px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbarSupportedContent" class="collapse navbar-collapse pl-5">
            <ul class="navbar-nav me-auto gap-3">
                <li class="nav-item">
                    <a href="{{ route('home') . '/#start' }}" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Buy me a Coffee</a>
                </li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav me-auto dropdown-menu-end gap-3">
                    @if(auth()->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="rounded-circle user-initial"
                                    style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; background-color: #6c757d; color: white; font-weight: bold;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/profile"><i class="bi bi-person-fill"></i> Perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right"></i> Sair</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{ url('/register') }}" class="btn btn-outline-primary">Registrar</a>
                        </li>
                    @endif

                    @include('components.darkmode')
                </ul>
            </div>
        </div>
    </div>
</nav>