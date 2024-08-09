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
                                <a href="{{route('resp.responsable.resp.profile')}}">
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
                <li class="nav-item {{ setMenuClass('resp.etudiant.inscription','active')}}">
                    <a href="{{route('resp.etudiant.inscription')}}">
                        <i class="fas fa-user-plus"></i>
                        <p>Inscription</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('resp.etudiant.liste_etudiant','active')}}">
                    <a href="{{route('resp.etudiant.liste_etudiant')}}">
                        <i class="fas fa-users-cog"></i>
                        <p>Listes élèves</p>
                    </a>
                </li>
                <li class="nav-item {{setMenuClass('resp.fiche.fiche_abscence','active')}}">
                    <a href="{{route('resp.fiche.fiche_abscence')}}">
                        <i class="fas fa-user-graduate"></i>
                        <p>Fiche étudiants</p>
                    </a>
                </li>
                <li class="nav-item {{setMenuClass('resp.notes.note_classe','active')}}">
                    <a href="{{route('resp.notes.note_classe')}}">
                        <i class="fas fa-tasks"></i>
                        <p>Notes</p>
                    </a>
                </li>

                <li class="nav-item {{setMenuClass('resp.professeur.','active submenu')}}">
                    <a data-toggle="collapse" href="#professeur">
                        <i class="fas fa-users"></i>
                        <p>Professeurs</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{setMenuClass('resp.professeur.','show')}}" id="professeur">
                        <ul class="nav nav-collapse">
                            <li class="{{ setMenuClass('resp.professeur.liste_prof','active')}}">
                                <a href="{{route('resp.professeur.liste_prof')}}">
                                    <span class="sub-item">Listes</span>
                                </a>
                            </li>
                            <li class="{{setMenuClass('resp.professeur.resp.fiche_prof','active')}}">
                                <a href="{{route('resp.professeur.resp.fiche_prof')}}">
                                    <span class="sub-item">Fiche de présence</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ setMenuClass('resp.cours.emploi_du_temps','active')}}">
                    <a href="{{route('resp.cours.emploi_du_temps')}}">
                        <i class="far fa-calendar-alt"></i>
                        <p>Cours</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('resp.responsable.resp.liste','active')}}">
                    <a href="{{route('resp.responsable.resp.liste')}}">
                        <i class="fas fa-user-friends"></i>
                        <p>Responsables</p>
                    </a>
                </li>
                <li class="nav-item {{setMenuClass('resp.cantines.','active submenu')}}">
                    <a data-toggle="collapse" href="#cantines">
                        <i class="fas fa-utensils"></i>
                        <p>Cantines</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{setMenuClass('resp.cantines.','show')}}" id="cantines">
                        <ul class="nav nav-collapse">
                            <li class="{{setMenuClass('resp.cantines.payement','active')}}">
                                <a href="{{route('resp.cantines.payement')}}">
                                    <span class="sub-item">Payements</span>
                                </a>
                            </li>
                            <li class="{{setMenuClass('resp.cantines.statistique','active')}}">
                                <a href="{{route('resp.cantines.statistique')}}">
                                    <span class="sub-item">Statistiques</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{setMenuClass('resp.transport.','active submenu')}}">
                    <a data-toggle="collapse" href="#transport">
                        <i class="fas fa-car"></i>
                        <p>Transports</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{setMenuClass('resp.transport.','show')}}" id="transport">
                        <ul class="nav nav-collapse">
                            <li class="{{setMenuClass('resp.transport.transport_scolaire','active')}}">
                                <a href="{{route('resp.transport.transport_scolaire')}}">
                                    <span class="sub-item">Payements</span>
                                </a>
                            </li>
                            <li class="{{setMenuClass('resp.transport.statistique_transport','active')}}">
                                <a href="{{route('resp.transport.statistique_transport')}}">
                                    <span class="sub-item">Statistiques</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{setMenuClass('resp.scolarite.','active submenu')}}">
                    <a data-toggle="collapse" href="#scolarites">
                        <i class="fas fa-dollar-sign"></i>
                        <p>Scolarités</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{setMenuClass('resp.scolarite.','show')}}" id="scolarites">
                        <ul class="nav nav-collapse">
                            <li class="{{setMenuClass('resp.transport.scolarite','active')}}">
                                <a href="{{route('resp.scolarite.scolarite')}}">
                                    <span class="sub-item">Payements</span>
                                </a>
                            </li>
                            <li class="{{setMenuClass('resp.scolarite.statistique_scolarite','active')}}">
                                <a href="{{route('resp.scolarite.statistique_scolarite')}}">
                                    <span class="sub-item">Statistiques</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
