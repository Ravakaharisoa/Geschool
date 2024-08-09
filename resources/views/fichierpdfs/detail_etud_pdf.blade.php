@extends('layouts.app_pdf')
@section('title','info etudiant')
@section('contents')
    <div class="wrapper">
        <section>
            <div class="row">
                <div class="col-6">
                    <h3 class="fw-bold text-primary">INFORMATIONS GENERALES</h3>
                    <div class="flex-column">
                        <p class="m-3">
                            <b>Nom </b> : {{ $eleve->nom }}
                        </p>
                        <p class="m-3">
                            <b>Prénoms </b> : {{ $eleve->prenom }}
                        </p>
                        <p class="m-3">
                            <b>Sexe </b> : {{ $eleve->sexe == 'fille' ? 'Fille' : 'Garçon' }}
                        </p>
                        <p class="m-3">
                             <b>Date de naissance </b> : {{ date_formate($eleve->date_naissance, 'd M Y') }}
                        </p>
                        <p class="m-3">
                            <b>N° Matricule </b> : {{ $eleve->matricule }}
                        </p>
                        <p class="m-3">
                            <b>Classe </b> : {{ $eleve->classe_annuel->nom_classe }}
                        </p>
                        <p class="m-3">
                            <b>Nationalité </b> : {{ $eleve->nationalite }}
                        </p>
                        <p class="m-3">
                            <b>Adresse </b> : {{ $eleve->adresse }}
                        </p>
                        <p class="m-3">
                            <b>Maladie </b> : {{ $eleve->maladie == 'rien' ? '-' : $eleve->maladie }}
                        </p>
                        <hr class="my-3">
                        <p class="m-3">
                            <b>Nom du Père</b> : {{ $eleve->nom_pere }}
                        </p>
                        <p class="m-3">
                            <b>Nom de la Mère </b> : {{ $eleve->nom_mere }}
                        </p>
                        <p class="m-3">
                            <b>Contact Primaire </b> : {{ $eleve->contact_prim }}
                        </p>
                        <p class="m-3">
                            <b>Contact Sécondaire </b> : {{ $eleve->contact_seco == null ? '-' : $eleve->contact_seco }}
                        </p>
                        <p class="m-3">
                            <b>Adresse Email </b> : {{ $eleve->email }}
                        </p>
                        <p class="m-3">
                            <b>Autres Information </b> : {{ $eleve->observation == null ? '-' : $eleve->observation }}
                        </p>
                    </div>
                    <hr class="my-3">
                    <h3 class="fw-bold text-primary">ABSCENCES</h3>
                    <div class="flex-column">
                        <p class="m-3">{{ $abscence->date_absence!=null ? date_formate($abscence->date_absence,"d M Y") :""}} &nbsp;&nbsp;{{$abscence->motif}}</p>
                    </div>
            <hr class="my-3">
                </div>
                <div class="col-6 pull-right autre_infos">
                    <div class="row text-center">
                        @if ($eleve->photo ==null)
                            <img src="{{ public_path('assets/img/defaultuser.png') }}" id="profile_photo" class="profile_photo" alt="">
                        @else
                            <img src="{{ public_path('assets/img/users/'.$eleve->photo) }}" id="profile_photo" class="profile_photo" alt="">
                        @endif
                        <p><b>Année Scolaire</b> : {{$anne->annee_sco}}</p>
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <h3 class="fw-bold text-primary">PAIEMENTS DE SCOLARITES</h3>
                        <div class="flex-column">
                            <p class="m-3">
                                <b>Scolarité à payer </b> : {{ nombre_format($eleve->classe_annuel->montant_total) }} AR
                            </p>
                            <p class="m-3">
                                <b>Scolarité payée </b> : {{ nombre_format($scolarite_paye)}} AR</p>
                            <p class="m-3">
                                <b>Reste à payée </b> : {{ nombre_format($eleve->classe_annuel->montant_total-$scolarite_paye) }} AR
                            </p>
                            <hr class="my-3">
                            <h3 class="fw-bold text-primary">CANTINES (Derniers paiements)</h3>
                            <div class="my-2">
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
                            <h3 class="fw-bold text-primary">TRANSPORTS (Derniers paiements)</h3>
                            <div class="my-2">
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
                </div>
            </div>
        </section>
    </div>
@endsection



