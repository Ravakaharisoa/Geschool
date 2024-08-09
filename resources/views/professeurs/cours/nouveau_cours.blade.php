@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp; Ajout et affichage des cours disponible</h2>
	</div>
    <hr>
</div>
<div class="row my-1">
    <form id="form_save_cours" class="w-100">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group form-show-validation">
                    <label for="heure_debut">Heure début :</label>
                    <input type="time" name="heure_debut" id="heure_debut" class="form-control">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group form-show-validation">
                    <label for="heure_fin">Heure fin :</label>
                    <input type="time" name="heure_fin" id="heure_fin" class="form-control">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group form-show-validation">
                    <label for="jour">Jour :</label>
                    <select name="jour" id="jour" class="form-control">
                        <option hidden selected>Choix</option>
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                        <option value="Dimanche">Dimanche</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group form-show-validation">
                    <label for="classe_id">Classe :</label>
                    <select name="classe_id" id="classe_id" class="form-control">
                        <option hidden selected>Choix</option>
                        @if (count($classes)>0)
                            @foreach ($classes as $classe)
                                <option value="{{$classe->id}}">{{$classe->nom_classe}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group form-show-validation">
                    <label for="matiere_id">Matière :</label>
                    <select name="matiere_id" id="matiere_id" class="form-control">
                        <option hidden selected>Choix</option>
                        @if (count($matieres)>0)
                            @foreach ($matieres as $matiere)
                                <option value="{{$matiere->id}}">{{$matiere->matiere}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-2 align-items-center py-3">
                <div class="col-sm-12 mt-3">
                    <button class="btn btn-success"><i class="fas fa-check"></i>&nbsp;&nbsp;Enregistrer</button>
                </div>
            </div>
        </div>
    </form>
</div>
<hr class="mt-3">
<div class="row my-1" id="liste_cours">

</div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/page/cours.js')}}"></script>
@endpush
