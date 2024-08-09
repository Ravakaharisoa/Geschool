@extends('layouts.app_page')
@section('contents')
    <div class="align-items-left align-items-md-center pt-3 pb-4">
        <div class="row justify-content-between mx-1">
            <h2 class="pb-2 fw-bold"><i class="fas fa-id-card"></i>&nbsp;&nbsp; Détails de l'élèves</h2>
            <a href="{{url()->previous()}}" title="Retour à la page précedante" class="text-dark"><i class="fas fa-arrow-alt-circle-left fa-2x"></i></a>
        </div>
        <hr>
    </div>
    <div class="row m-1 py-3">
        <div class="col-lg-6 p-2">
            <h3 class="fw-bold">INFORMATIONS GENERALES</h3>
            <div class="d-flex flex-column">
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Nom </b></div>
                    <div class="col-md-6">: {{ $eleve->nom }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Prénoms </b></div>
                    <div class="col-md-6">: {{ $eleve->prenom }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Sexe </b></div>
                    <div class="col-md-6">: {{ $eleve->sexe == 'fille' ? 'Fille' : 'Garçon' }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"> <b>Date de naissance </b></div>
                    <div class="col-md-6">: {{ date_formate($eleve->date_naissance, 'd M Y') }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>N° Matricule </b></div>
                    <div class="col-md-6">: {{ $eleve->matricule }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Classe </b></div>
                    <div class="col-md-6">: {{ $eleve->classe_annuel->nom_classe }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Nationalité </b></div>
                    <div class="col-md-6">: {{ $eleve->nationalite }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Adresse </b></div>
                    <div class="col-md-6">: {{ $eleve->adresse }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Maladie </b></div>
                    <div class="col-md-6">: {{ $eleve->maladie == 'rien' || $eleve->maladie == null ? '-' : $eleve->maladie }}</div>
                </span>
            </div>
            <hr class="my-3">
            <div class="d-flex flex-column">
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Nom du Père</b></div>
                    <div class="col-md-6">: {{ $eleve->nom_pere }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Nom de la Mère </b></div>
                    <div class="col-md-6">: {{ $eleve->nom_mere }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Contact Primaire </b></div>
                    <div class="col-md-6">: {{ $eleve->contact_prim }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Contact Sécondaire </b></div>
                    <div class="col-md-6">: {{ $eleve->contact_seco == null ? '-' : $eleve->contact_seco }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Adresse Email </b></div>
                    <div class="col-md-6">: {{ $eleve->email }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Autres Information </b></div>
                    <div class="col-md-6">: {{ $eleve->observation == null ? '-' : $eleve->observation }}</div>
                </span>
            </div>
            <hr class="my-3">
            <h3 class="fw-bold">ABSCENCES</h3>
            <div class="d-flex flex-column">
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>{{ $abscence ? date_formate($abscence->date_absence,"d M Y") :""}}</b></div>
                    <div class="col-md-6">{{$abscence ?$abscence->motif:""}}</div>
                </span>
            </div>
            <hr class="my-3">
        </div>
        <div class="col-lg-6 p-2">
            <div class="d-flex flex-column">
                <div>
                    @if ($eleve->photo ==null)
                        <img src="{{ asset('assets/img/defaultuser.png') }}" id="profile_photo" class="profile_photo" alt="">
                    @else
                        <img src="{{ asset('assets/img/users/'.$eleve->photo) }}" id="profile_photo" class="profile_photo" alt="">
                    @endif
                </div>
                <span class="m-1 py-2"><b>Année Scolaire</b> : {{$anne->annee_sco}}</span>
            </div>
            <hr class="my-3">
            <h3 class="fw-bold">PAIEMENTS DE SCOLARITES</h3>
            <div class="d-flex flex-column">
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Scolarité à payer </b></div>
                    <div class="col-md-6">: {{ nombre_format($eleve->classe_annuel->montant_total) }} AR</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Scolarité payée </b></div>
                    <div class="col-md-6">: {{ nombre_format($scolarite_paye)}} AR</div></span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-4"><b>Reste à payée </b></div>
                    <div class="col-md-6">: {{ nombre_format($eleve->classe_annuel->montant_total-$scolarite_paye) }} AR</div>
                </span>
            </div>
            <hr class="my-3">
            <h3 class="fw-bold">CANTINES (Derniers paiements)</h3>
            <div class="mx-3 w-50">
                @if (count($cantines)>0)
                    <table class="table">
                        <tbody>
                            @foreach ($cantines as $cantine)
                                <tr>
                                    <td>{{date_formate($cantine->date_cantine,"d M Y")}}</td>
                                    <td>{{nombre_format($cantine->montant)}} AR</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <hr class="my-3">
            <h3 class="fw-bold">TRANSPORTS (Derniers paiements)</h3>
            <div class="mx-3 w-50">
                @if (count($transports)>0)
                    <table class="table">
                        <tbody>
                            @foreach ($transports as $transport)
                                <tr>
                                    <td>{{ucfirst(date_formate($transport->mois,"M Y"))}}</td>
                                    <td>{{nombre_format($transport->montant)}} AR</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <hr class="my-3">
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/page/detail_etud.js')}}"></script>
@endpush
