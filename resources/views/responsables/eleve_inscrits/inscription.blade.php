@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="fas fa-user-plus"></i>&nbsp;&nbsp; Nouvelle Inscription</h2>
	</div>
    <hr>
</div>
<div class="row mx-1">
    <form id="form-inscription" class="w-100">
        <div class="row mx-1">
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="nom_etud">Nom <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="nom_etud" name="nom_etud">
                </div>
                <div class="form-group">
                    <label for="matricule_etud">N° Matricule <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="matricule_etud" name="matricule_etud">
                </div>
                <div class="form-group">
                    <label for="maladie_etud">Maladie particulier <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="maladie_etud" name="maladie_etud">
                </div>
                <div class="form-group">
                    <label for="contact1_etud">Contact Primaire <span class="text-danger">*</span> :</label>
                    <input type="tel" class="form-control telephone" id="contact1_etud" name="contact1_etud">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="prenom_etud">Prénom(s) :</label>
                    <input type="text" class="form-control" id="prenom_etud" name="prenom_etud">
                </div>
                <div class="form-group">
                    <label for="classe_etud">Classe <span class="text-danger">*</span> :</label>
                    <select class="form-control" id="classe_etud" name="classe_etud">
                        <option hidden selected></option>
                        @if (count($classes)>0)
                            @foreach ($classes as $classe)
                                <option value="{{$classe->id}}">{{$classe->nom_classe}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="nom_pere">Nom du Père <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="nom_pere" name="nom_pere">
                </div>
                <div class="form-group">
                    <label for="contact2_etud">Contact Sécondaire :</label>
                    <input type="tel" class="form-control telephone" id="contact2_etud" name="contact2_etud">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="sexe_etud">Sexe <span class="text-danger">*</span> :</label>
                    <select class="form-control" id="sexe_etud" name="sexe_etud">
                        <option hidden selected></option>
                        <option value="garcon">Garçon</option>
                        <option value="fille">Fille</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nationalite_etud">Nationalité <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="nationalite_etud" name="nationalite_etud">
                </div>
                <div class="form-group">
                    <label for="nom_mere">Nom de la Mère <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="nom_mere" name="nom_mere">
                </div>
                <div class="form-group">
                    <label for="reduction_etud">Réduction :</label>
                    <input type="number" class="form-control" id="reduction_etud" name="reduction_etud">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="date_nais_etud">Date de naissance <span class="text-danger">*</span> :</label>
                    <input type="date" class="form-control" id="date_nais_etud" name="date_nais_etud">
                </div>
                <div class="form-group">
                    <label for="adresse_etud">Adresse <span class="text-danger">*</span> :</label>
                    <input type="text" class="form-control" id="adresse_etud" name="adresse_etud">
                </div>
                <div class="form-group">
                    <label for="email_etud">Adresse Email <span class="text-danger">*</span> :</label>
                    <input type="email" class="form-control" id="email_etud" name="email_etud">
                </div>
                <div class="form-group">
                    <label for="autre_info">Autres informations :</label>
                    <textarea class="form-control" id="autre_info" name="autre_info" rows="1"></textarea>
                </div>
            </div>
        </div>
        <hr class="my-3">
        <div class="row mx-3 my-3">
            <div class="col-sm-12 text-right">
                <button class="btn btn-success"><i class="fas fa-check"></i>&nbsp;&nbsp; Enregistrer</button>
                <button class="btn btn-danger"><i class="fas fa-times"></i> &nbsp;&nbsp;Annuler</button>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/page/resp.js')}}"></script>
@endpush
