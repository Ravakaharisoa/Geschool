<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    @if (Auth()->user()->photo !=null)
                        <img src="{{asset('assets/img/users/'.Auth()->user()->photo)}}" alt="..." class="avatar-img rounded-circle">
                    @else
                        <img src="{{asset('assets/img/defaultuser.png')}}" alt="..." class="avatar-img rounded-circle">
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
                                <a href="{{route('etudiant.profile.etud_profil')}}">
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
                <li class="nav-item {{ setMenuClass('etudiant.hitsorique.historique_abscence','active')}}">
                    <a href="{{route('etudiant.hitsorique.historique_abscence')}}">
                        <i class="fas fa-tasks"></i>
                        <p>Historiques</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('etudiant.classes.camarade_classe','active')}}">
                    <a href="{{route('etudiant.classes.camarade_classe')}}">
                        <i class="fas fa-user-graduate"></i>
                        <p>Camarade de classe</p>
                    </a>
                </li>

                <li class="nav-item {{ setMenuClass('etudiant.classes.note.etud','active')}}">
                    <a href="{{route('etudiant.classes.note.etud')}}">
                        <i class="fas fa-tasks"></i>
                        <p>Notes</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('etudiant.professeur.liste_prof_dispo','active')}}">
                    <a href="{{route('etudiant.professeur.liste_prof_dispo')}}">
                        <i class="fas fa-user"></i>
                        <p>Professeurs</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('etudiant.classes.liste_cours','active')}}">
                    <a href="{{route('etudiant.classes.liste_cours')}}">
                        <i class="far fa-calendar-alt"></i>
                        <p>Emploi du temps</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('etudiant.responsable.liste.dispo','active')}}">
                    <a href="{{route('etudiant.responsable.liste.dispo')}}">
                        <i class="fas fa-user-friends"></i>
                        <p>Responsables</p>
                    </a>
                </li>

                <li class="nav-item {{setMenuClass('etudiant.paiements.','active submenu')}}">
                    <a data-toggle="collapse" href="#paiement">
                        <i class="fas fa-dollar-sign"></i>
                        <p>Payements</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{setMenuClass('etudiant.paiements.','show')}}" id="paiement">
                        <ul class="nav nav-collapse">
                            <li class="{{setMenuClass('etudiant.paiements.paye_scolarite','active')}}">
                                <a href="{{route('etudiant.paiements.paye_scolarite')}}">
                                    <span class="sub-item">Scolarités</span>
                                </a>
                            </li>
                            <li class="{{setMenuClass('etudiant.paiements.paye_cantine','active')}}">
                                <a href="{{route('etudiant.paiements.paye_cantine')}}">
                                    <span class="sub-item">Cantines</span>
                                </a>
                            </li>
                            <li {{setMenuClass('etudiant.paiements.paye_transport','active')}}>
                                <a href="{{route('etudiant.paiements.paye_transport')}}">
                                    <span class="sub-item">Transports</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
