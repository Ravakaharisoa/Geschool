@extends('layouts.app_page')
@section('contents')
    <div class="align-items-left align-items-md-center pt-3 pb-4">
		<div class="">
			<h2 class="pb-2 fw-bold"><i class="fas fa-user-plus"></i>&nbsp;&nbsp; Nouveau Professeur</h2>
		</div>
        <hr>
	</div>
	<div class="align-items-left align-items-md-center pt-2 pb-2">
        <div class="wizard-container wizard-round col-md-12">
            <div class="wizard-header text-center">
                <h3 class="wizard-title"><b>Enregistrement Informations du professeur</b></h3>
            </div>
            <form method="POST" action="#" id="formulaire_prof">
                <div class="wizard-body">
                    <div class="row">
                        <ul class="wizard-menu nav nav-pills nav-primary">
                            <li class="step" style="width: 33.3333%;">
                                <a class="nav-link active" href="#about" data-toggle="tab" aria-expanded="true"><i class="fa fa-user mr-0"></i> Personnels</a>
                            </li>
                            <li class="step" style="width: 33.3333%;">
                                <a class="nav-link" href="#account" data-toggle="tab"><i class="fa fa-file mr-2"></i> Professionnels</a>
                            </li>
                            <li class="step" style="width: 33.3333%;">
                                <a class="nav-link" href="#address" data-toggle="tab"><i class="fa fa-map-signs mr-2"></i>Contacts</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="about">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nom :</label>
                                        <input name="nom" id="nom_prof" type="text" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Prénom(s) :</label>
                                        <input name="prenom" id="prenom_prof" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Adresse :</label>
                                        <input name="adresse" id="adresse_prof" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Sexe :</label>
                                        <select name="sexe" id="sexe_prof" class="form-control" required>
                                            <option hidden selected></option>
                                            <option value="Homme">Homme</option>
                                            <option value="Femme">Femme</option>
                                            <option value="Autre">Autre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="account">
                            <div class="row">
                                <div class="col-md-8 ml-auto mr-auto">
                                    <div class="form-group">
                                        <label>Matricule :</label>
                                        <input name="matricule" id="matricule_prof" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date d'Embauche :</label>
                                        <input name="date_embauche" id="date_embauche_prof" type="date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Type contrat :</label>
                                        <select name="contrat" id="contrat" class="form-control" required>
                                            <option hidden selected></option>
                                            <option value="CDI">CDI</option>
                                            <option value="CDD">CDD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="address">
                            <div class="row">
                                <div class="col-sm-8 ml-auto mr-auto">
                                    <div class="form-group">
                                        <label>Email :</label>
                                        <input type="email" id="email_prof" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Contact primaire :</label>
                                        <input type="text" id="contact1_prof" name="contact1" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Contact sécondaire :</label>
                                        <input type="text" id="contact2_prof" name="contact2" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wizard-action">
                    <div class="pull-left">
                        <input type="button" class="btn btn-previous btn-fill btn-black" name="previous" value="Précedent">
                    </div>
                    <div class="pull-right">
                        <input type="button" class="btn btn-next btn-primary" name="next" value="Suivant">
                        <input type="submit" class="btn btn-finish btn-success" name="finish" value="Términer" style="display: none;">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
	</div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/page/main.js')}}"></script>
@endpush

