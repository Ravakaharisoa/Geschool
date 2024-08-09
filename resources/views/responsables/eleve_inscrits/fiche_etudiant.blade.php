@extends('layouts.app_page')
@inject('classe','App\Models\Classe')
@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="fas fa-address-card"></i>&nbsp;&nbsp; Fiche d'abscence des élèves</h2>
	</div>
    <hr>
</div>
<div class="row my-1 mx-3">
    <div class="alert alert-info alert-dismissible w-100" role="alert">
        <strong>Pour afficher les détails d'abscence des étudiants, vous devez choisir les dates d'abscence</strong>
        <button type="button" class="close mt--2 mr-2" data-dismiss="alert">&times;</button>
    </div>
</div>
<div class="row mx-3">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Date début :</label>
            <input type="date" name="date_debut" id="date_debut" class="form-control">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Date fin :</label>
            <input type="date" name="date_fin" id="date_fin" class="form-control">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group mt-4">
            <button class="btn btn-success" id="affiche_det_abs">Afficher les détails</button>
        </div>
    </div>
</div>
<div class="row mx-3 my-1" id="liste_abscences">
    <div class="col-md-12 mx-1 my-3 pt-1">
        <div class="border border-dark w-100 p-3">
            <div class="row justify-content-between mx-1">
                <div class="">
                    <h5><i class="far fa-bell"></i>&nbsp;&nbsp;LISTES D'ABSCENCES DES ELEVES</h5>
                </div>
                <div class="col-md-3">
                    <input type="search" name="search_table" class="form-control search_table" placeholder="Recherche ...">
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>N°</th>
                            <th>NOMS et PRENOMS</th>
                            <th>MATRICULE</th>
                            <th>CLASSE</th>
                            <th>DATE ABS.</th>
                            <th>HEURE ABS</th>
                            <th>MOTIFS</th>
                            <th>COURS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if (count($abscences)>0)
                            @foreach ($abscences as $abscence)
                                <tr>
                                    <td>{{$indice++}}</td>
                                    <td>{{$abscence->etudiant->nom}} &nbsp;{{$abscence->etudiant->prenom}}</td>
                                    <td>{{$abscence->etudiant->matricule}}</td>
                                    <td>{{$classe->classe_name($abscence->etudiant->classe_id)}}</td>
                                    <td>{{date_formate($abscence->date_absence,"l d M Y")}}</td>
                                    <td>{{heure_format($abscence->cour->heure_debut,'H').'h'.heure_format($abscence->cour->heure_debut,'i')}}&nbsp;à&nbsp;{{heure_format($abscence->cour->heure_fin,'H').'h'.heure_format($abscence->cour->heure_fin,'i')}}</td>
                                    <td>{{$abscence->motif}}</td>
                                    <td>{{$classe->matiere_name($abscence->cour->matiere_id)}}</td>
                                    <td>
                                        <a href="#" id="{{$abscence->id}}" class="text-primary motif_abs" title="Ajouter motif d'abscence"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="9">Aucun élève inscrit abscent </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/page/resp.js')}}"></script>
@endpush
