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
                    <a data-toggle="collapse" href="#compte" aria-expanded="true">
                        <span>
                            {{getRoleName()}}
                            <span class="user-level">{{userFullName()}}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse {{setMenuClass('prof.profile.','show')}}" id="compte">
                        <ul class="nav">
                            <li class="{{setMenuClass('prof.profile.prof_profil','active')}}">
                                <a href="{{route('prof.profile.prof_profil')}}">
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
                <li class="nav-item {{ setMenuClass('prof.eleves.liste.eleve','active')}}">
                    <a href="{{route('prof.eleves.liste.eleve')}}">
                        <i class="fas fa-user-graduate"></i>
                        <p>Détails élèves</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('prof.notes.liste_notes','active')}}">
                    <a href="{{route('prof.notes.liste_notes')}}">
                        <i class="fas fa-tasks"></i>
                        <p>Notes</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('prof.cour.prof.cours','active')}}">
                    <a href="{{route('prof.cour.prof.cours')}}">
                        <i class="far fa-calendar-alt"></i>
                        <p>Cours</p>
                    </a>
                </li>
                <li class="nav-item {{ setMenuClass('prof.responsable.liste.resp','active')}}">
                    <a href="{{route('prof.responsable.liste.resp')}}">
                        <i class="fas fa-user-friends"></i>
                        <p>Responsables</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
