@extends('layouts.app_pdf')
@section('title', 'bulletin de note')
@section('contents')
    @inject('note_etud', 'App\Models\Note')
    <div class="wrapper">
        <section>
            <div class="row justify-content-center">
                <img src="{{ public_path('assets/img/ecoles/' . $ecole->logo) }}" alt="" srcset="" width="90"
                    height="90">
                <p class="fw-bold">Ecole Privée {{ strtoupper($ecole->nom) }}</p>
                <p class="fw-bold text-primary">{{ strtoupper($ecole->slogan) }}</p>
            </div>
        </section>
        <section>
            <div class="row justify-content-between">
                <h4 class="fw-bold">Année Scolaire : {{$eleve->anneeScol->annee_sco}}</h4>
                <h4 class="fw-bold pull-right module">Module : {{strtoupper($module->trimestre)}}</h4>
            </div>
        </section>
        <hr>
        <section>
            <div class="row">
                <div class="col-6">
                    <div class="flex-column">
                        <p>Nom : <b>{{strtoupper($eleve->nom)}}</b></p>
                        <p>Prénom : <b>{{ucwords($eleve->prenom)}}</b></p>
                        <p>Matricule : <b>{{$eleve->matricule}}</b></p>
                    </div>
                </div>
                <div class="col-6 autre_info pull-right">
                    <div class="flex-column text-right">
                        <p>Date de naissance : <b>{{date_formate($eleve->date_naissance,"d/m/Y")}}</b></p>
                        <p>Lieu de naissance : <b>{{strtoupper($eleve->lieu_naissance)}}</b></p>
                        <p>Classe : <b>{{$eleve->classe_annuel->nom_classe}}</b></p>
                    </div>
                </div>
            </div>
        </section>
        <hr>
        <section>
            <div class="table-responsive">
                <table class="table table-bordered w-100">
                    <thead class="text-primary">
                        <tr>
                            <td></td>
                            @if (count($types)>0)
                                @foreach ($types as $type)
                                    <td class="text-center"><strong>{{$type->type}}</strong></td>
                                @endforeach
                            @endif
                            <td class="text-center"><strong>COEFF.</strong></td>
                            <td class="text-right"><strong>NOTES</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($matieres)>0)
                            @foreach ($matieres as $matiere)
                                <tr>
                                    <td>{{$matiere->matiere}}</td>
                                    @if (count($types)>0)
                                        @foreach ($types as $typ)
                                            <td class="text-center">{{$note_etud->note_eleve($matiere->id,$typ->id,$module->id,$eleve->id)}}</td>
                                        @endforeach
                                    @endif
                                    <td class="text-center text-danger">{{$note_etud->coefficient_note($matiere->id,$module->id,$eleve->id)}}</td>
                                    <td class="text-center">{{$note_etud->total_note_matiere($eleve->id,$module->id,$matiere->id)}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right fw-bold" colspan="{{$row}}">TOTAL</td>
                            <td class="text-center text-danger">{{$note_etud->somme_coeff($eleve->id,$module->id)}}</td>
                            <td class="text-center fw-bold">{{$note_etud->total_note($eleve->id,$module->id)}}</td>
                        </tr>
                        <tr>
                            <td class="text-right fw-bold" colspan="{{$row}}">MOYENNE</td>
                            <td class="text-center"></td>
                            <td class="text-center fw-bold">
                                @if ($note_etud->total_note($eleve->id,$module->id)>0 && $note_etud->somme_coeff($eleve->id,$module->id)>0)
                                    @php
                                        $moyenne =$note_etud->total_note($eleve->id,$module->id)/$note_etud->somme_coeff($eleve->id,$module->id);
                                    @endphp
                                @else
                                    @php
                                        $moyenne =0;
                                    @endphp
                                @endif

                                {{$moyenne}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <hr style="margin-top: 15px;margin-bottom:15px;width:50%;margin:aut0;">
        <section>
            <div class="row">
                <h6 class="text-uppercase mt-2 mb-2 fw-bold">
                    Obsérvation
                </h6>
                <p class="fs-6 mb-0 fw-bold text-danger"><i>
                   {{observation($moyenne)}}</i>
                </p>
            </div>
        </section>
    @endsection
