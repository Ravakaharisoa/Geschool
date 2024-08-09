
<div class="main-header">
    <div class="logo-header" data-background-color="blue">
        <a href="{{route('home')}}" class="logo text-center">
            <img src="{{asset('assets/img/animations/logo.png')}}" alt="navbar brand" class="navbar-brand">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue">

        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn" aria-labelledby="cogDropdown">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                @can('isDirecteur')
                                    <a class="dropdown-item" href="{{route('ecole')}}"><i class="fas fa-cogs"></i> &nbsp;&nbsp;Modifier nom école</a>
                                @endcan
                                <a class="dropdown-item" href="{{route('anneeScol')}}"><i class="fas fa-cogs"></i> &nbsp;&nbsp;
                                    @canany(['isDirecteur', 'isResponsable'])
                                        Ajout
                                    @endcanany
                                    Année Scolaire</a>
                                <a class="dropdown-item" href="{{route('classe')}}"><i class="fas fa-cogs"></i> &nbsp;&nbsp;
                                    @canany(['isDirecteur', 'isResponsable'])
                                         Ajout de
                                    @endcanany
                                   Classe</a>
                                <a class="dropdown-item" href="{{route('module')}}"><i class="fas fa-cogs"></i> &nbsp;&nbsp;
                                    @canany(['isDirecteur', 'isResponsable'])
                                        Ajout de
                                    @endcanany
                                     Module</a>
                                <a class="dropdown-item" href="{{route('matiere')}}"><i class="fas fa-cogs"></i> &nbsp;&nbsp;
                                    @canany(['isDirecteur', 'isResponsable'])
                                        Ajout de
                                    @endcanany
                                     Matière</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> &nbsp;&nbsp;Se déconnecter</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </li>
                        </div>
                    </ul>
                </li>
                <li class="nav-item">
                    <button href="#" class="btn btn-success btn-sm" id="select_anneeSco">
                        2000-2001
                    </button>
                </li>
            </ul>
        </div>
    </nav>
</div>
