@extends('layouts.app_page')
@section('contents')
@inject('note_etud','App\Models\Note')
    <div class="align-items-left align-items-md-center pt-3 pb-4">
        <div>
            <h2 class="pb-2"><i class="fas fa-clipboard-list"></i>&nbsp;&nbsp; Bulletin de : <b>{{$eleve->nom}} &nbsp; {{$eleve->prenom}}</b>, classe de : <b>{{$eleve->classe_annuel->nom_classe}}</b></h2>
        </div>
        <hr>
    </div>
    @if (count($notes)>0)
        <div class="row m-1 p-1 justify-content-between">
            @foreach ($modules as $module)
            <div class="col-12 col-lg-10 ">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="page-pretitle">
                            Bulletin
                        </h6>
                        <h4 class="page-title">
                            {{$module->trimestre}}
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{route('resp.etudiant.imprimer_bulletin',[$eleve->id,$module->id])}}" class="btn btn-primary btn-sm download_note" title="Télécharger">
                            <i class="fas fa-cloud-download-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="page-divider"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-invoice">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <h4 class="fw-bold">Année Scolaire : {{$eleve->anneeScol->annee_sco}}</h4>
                                    <h4 class="fw-bold">Module : {{$module->trimestre}}</h4>
                                </div>
                                <div class="separator-solid"></div>
                                <div class="invoice-header">
                                    <div class="d-flex flex-column">
                                        <span class="my-1">Nom : <b>{{$eleve->nom}}</b></span>
                                        <span class="my-1">Prénom : <b>{{$eleve->prenom}}</b></span>
                                        <span class="mt-1">Matricule : <b>{{$eleve->matricule}}</b></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="my-1">Date de naissance : <b>{{date_formate($eleve->date_naissance,"d/m/Y")}}</b></span>
                                        <span class="my-1">Lieu de naissance : <b>{{strtoupper($eleve->lieu_naissance)}}</b></span>
                                        <span class="mt-1">Classe : <b>{{$eleve->classe_annuel->nom_classe}}</b></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="separator-solid"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="invoice-detail">
                                            <div class="invoice-item">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td></td>
                                                                @if (count($types)>0)
                                                                    @foreach ($types as $type)
                                                                        <td class="text-center"><strong>{{$type->type}}</strong></td>
                                                                    @endforeach
                                                                @endif
                                                                <td class="text-center"><strong>COEFFICIENT</strong></td>
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
                                                                        <td class="text-center">{{$note_etud->coefficient_note($matiere->id,$module->id,$eleve->id)}}</td>
                                                                        <td class="text-center">{{$note_etud->total_note_matiere($eleve->id,$module->id,$matiere->id)}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="text-right fw-bold" colspan="{{$row}}">TOTAL</td>
                                                                <td class="text-center">{{$note_etud->somme_coeff($eleve->id,$module->id)}}</td>
                                                                <td class="text-center fw-bold">{{$note_etud->total_note($eleve->id,$module->id)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-right fw-bold" colspan="{{$row}}">MOYENNE</td>
                                                                <td class="text-center"></td>
                                                                <td class="text-center fw-bold">
                                                                    @php
                                                                        $moyenne =$note_etud->total_note($eleve->id,$module->id)/$note_etud->somme_coeff($eleve->id,$module->id);
                                                                    @endphp
                                                                    {{$moyenne}}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator-solid  mb-3"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <h6 class="text-uppercase mt-2 mb-2 fw-bold">
                                    Obsérvation
                                </h6>
                                <p class="fs-6 mb-0 fw-bold text-danger"><i>
                                   {{observation($moyenne)}}</i>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else

    @endif
@endsection
