@extends('layouts.app_page')
@section('contents')
@inject('cour','App\Models\Cour')
    <div class="align-items-left align-items-md-center pt-3 pb-4">
        <div class="row justify-content-between mx-1">
            <h2 class="pb-2 fw-bold"><i class="fas fa-id-card"></i>&nbsp;&nbsp; Détails de l'élèves</h2>
            <a href="{{url()->previous()}}" title="Retour à la page précedante" class="text-dark"><i class="fas fa-arrow-alt-circle-left fa-2x"></i></a>
        </div>
        <hr>
    </div>
    <div class="row m-1 py-3">
        <div class="col-lg-5 p-2">
            <h3 class="fw-bold">INFORMATIONS GENERALES</h3>
            <hr class="my-3">
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
            <div class="d-flex flex-column">
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>Nom </b></div>
                    <div class="col-md-5">: {{ $eleve->nom }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>Prénoms </b></div>
                    <div class="col-md-5">: {{ $eleve->prenom }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>Sexe </b></div>
                    <div class="col-md-5">: {{ $eleve->sexe == 'fille' ? 'Fille' : 'Garçon' }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"> <b>Date de naissance </b></div>
                    <div class="col-md-5">: {{ date_formate($eleve->date_naissance, 'd M Y') }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>N° Matricule </b></div>
                    <div class="col-md-5">: {{ $eleve->matricule }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>Classe </b></div>
                    <div class="col-md-5">: {{ $eleve->classe_annuel->nom_classe }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>Nationalité </b></div>
                    <div class="col-md-5">: {{ $eleve->nationalite }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>Adresse </b></div>
                    <div class="col-md-5">: {{ $eleve->adresse }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>Contact Primaire </b></div>
                    <div class="col-md-5">: {{ $eleve->contact_prim }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>Adresse Email </b></div>
                    <div class="col-md-5">: {{ $eleve->email }}</div>
                </span>
                <span class="m-1 d-flex align-items-center">
                    <div class="col-md-5"><b>Maladie </b></div>
                    <div class="col-md-5">: {{ $eleve->maladie == 'rien' || $eleve->maladie == null ? '-' : $eleve->maladie }}</div>
                </span>
            </div>
            <hr class="my-3">
            <h3 class="fw-bold">ABSCENCES</h3>
            <hr class="my-3">
            @if (count($abscences)>0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>DATE ABSCENCE</th>
                                <th>HEURES</th>
                                <th>JOURS</th>
                                <th>MATIERES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($abscences as $abscence)
                                <tr>
                                    <td>{{date_formate($abscence->date_absence,"d M Y")}}</td>
                                    <td>{{heure_format($abscence->cour->heure_debut,'H').'h'.heure_format($abscence->cour->heure_debut,'i')}}&nbsp;à&nbsp;{{heure_format($abscence->cour->heure_fin,'H').'h'.heure_format($abscence->cour->heure_fin,'i')}}</td>
                                    <td>{{ucwords(date_formate($abscence->date_absence,"l"))}}</td>
                                    <td>{{$cour->nom_matiere($abscence->cour->matiere_id)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr class="my-3">
            @endif
        </div>
        <div class="col-lg-7 p-2">
            <h3 class="fw-bold">NOTES</h3>
            <hr class="my-3">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Matière</th>
                            <th>Modules</th>
                            <th>Type Examen</th>
                            <th>Date d'examen</th>
                            <th>Notes</th>
                            <th>Coefficient</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if (count($notes)>0)
                            @foreach ($notes as $note)
                                <tr>
                                    <td>{{$note->matieres->matiere}}</td>
                                    <td>{{$note->module->trimestre}}</td>
                                    <td>{{$note->typeExam->type}}</td>
                                    <td>{{date_formate($note->date_evaluation,"d M Y")}}</td>
                                    <td>{{$note->note}}</td>
                                    <td>{{$note->coefficient}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">Aucun note disponible</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/page/prof.js')}}"></script>
@endpush
