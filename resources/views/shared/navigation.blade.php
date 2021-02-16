<nav class="navbar navbar-expand-md shadow-sm navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/"><img class="logo " src="../assets/icons/logo.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                @auth
                    @if(auth()->user()->isAdmin or auth()->user()->isReceptionist)

                        <li class="nav-item">
                            <a class="nav-link" href="/admin/plannings">Planning</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/users">Gebruikers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/kades">Kades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/soorts">Proces</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/bedrijven">Bedrijven</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/nummerplaats">Nummerplaten</a>
                        </li>

                    @endif

                @endauth
            </ul>
            {{--  Auth navigation  --}}
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i>Inloggen</a>
                    </li>

                @endguest

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#!" data-toggle="dropdown">
                            {{ auth()->user()->naam }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/user/password"><i class="fas fa-key"></i>Paswoord aanpassen</a>
                            @if(auth()->user()->isAdmin or auth()->user()->isReceptionist)
                            <a class="dropdown-item" href="/admin/inzichten"><i class="fas fa-chart-bar"></i>inzichten</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt"></i>Uitloggen</a>
                        </div>
                    </li>
                @endauth
            </ul>

        </div>
    </div>
</nav>

@yield('sidebar')



