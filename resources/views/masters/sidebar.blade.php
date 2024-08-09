<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    @if (Auth()->user()->photo !=null)
                        <img src="{{asset('assets/img/users/'.Auth()->user()->photo)}}" alt="photo" class="avatar-img rounded-circle">
                    @else
                        <img src="{{asset('assets/img/defaultuser.png')}}" alt="photo" class="avatar-img rounded-circle">
                    @endif
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{getRoleName()}}
                            <span class="user-level">{{userFullName()}}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="{{route('admin.directeur.directeur.profile')}}">
                                    <span class="link-collapse"> Mon Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item {{ setMenuClass('home','active')}}">
                    <a href="{{route('home')}}">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('admin.eleves.liste_classe','active')}}">
                    <a href="{{route('admin.eleves.liste_classe')}}">
                        <i class="fas fa-users-cog"></i>
                        <p>Listes élèves</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('admin.professeur.','active submenu')}}">
                    <a data-toggle="collapse" href="#professeurs">
                        <i class="fas fa-users"></i>
                        <p>Professeurs</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ setMenuClass('admin.professeur.','show')}}" id="professeurs">
                        <ul class="nav nav-collapse">
                            <li class="{{ setMenuClass('admin.professeur.new_prof','active')}}">
                                <a href="{{route('admin.professeur.new_prof')}}">
                                    <span class="sub-item">Nouveau  Profs</span>
                                </a>
                            </li>
                            <li class="{{ setMenuClass('admin.professeur.professeurs','active')}}">
                                <a href="{{route('admin.professeur.professeurs')}}">
                                    <span class="sub-item">Liste Profs</span>
                                </a>
                            </li>
                            <li class="{{ setMenuClass('admin.professeur.fiche_prof','active')}}">
                                <a href="{{route('admin.professeur.fiche_prof')}}">
                                    <span class="sub-item">Fiche présence</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ setMenuClass('admin.emploi_temp.emploi_temps','active')}}">
                    <a href="{{route('admin.emploi_temp.emploi_temps')}}">
                        <i class="fas fa-calendar"></i>
                        <p>Emploi du temps</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('admin.responsable.','active submenu')}}">
                    <a data-toggle="collapse" href="#responsables">
                        <i class="fas fa-user-friends"></i>
                        <p>Responsables</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ setMenuClass('admin.responsable.','show')}}" id="responsables">
                        <ul class="nav nav-collapse">
                            <li class="{{ setMenuClass('admin.responsable.new_responsable','active')}}">
                                <a href="{{route('admin.responsable.new_responsable')}}">
                                    <span class="sub-item">Ajouter</span>
                                </a>
                            </li>
                            <li class="{{ setMenuClass('admin.responsable.responsable','active')}}">
                                <a href="{{route('admin.responsable.responsable')}}">
                                    <span class="sub-item">Listes</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

