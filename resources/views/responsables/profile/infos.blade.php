@extends('layouts.app')
@section('contenu')
<div class="row">
    <div class="col-md-11 m-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title fw-bold"><i class="far fa-address-card"></i>&nbsp; Veuillez remplir vos informations</div>
            </div>
            <form  id="formulaire_resp" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="form-group form-show-validation row">
                            <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 fw-bold text-right">Photo :<span class="required-label">*</span></label>
                            <div class="col-lg-7 col-md-9 col-sm-8">
                                <div class="input-file input-file-image">
                                    <img class="img-upload-preview img-circle" width="100" height="100" src="{{asset('assets/img/defaultuser.png')}}" alt="preview">
                                    <input type="file" class="form-control form-control-file" id="uploadImg_resp" name="uploadImg_resp" accept="image/*" required >
                                    <label for="uploadImg_resp" class="btn btn-primary btn-round btn-sm"><i class="fa fa-file-image"></i> Choisir image</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator-solid"></div>
                    <div class="row col-md-12">
                        <div class="col-md-6 col-lg-6">
                            <h3 class="text-center fw-bold">Informations Personnelles</h3>
                            <hr class="mx-3">
                            <div class="form-group">
                                <label class="fw-bold" for="nom_resp">Nom : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control" id="nom_resp" name="nom_resp" value="{{$resp->nom}}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="prenom_resp">Prénom : </label>
                                <input type="text" class="form-control" id="prenom_resp" name="prenom_resp" {{$resp->prenom != null ? "disabled":"" }} value="{{$resp->prenom != null ? $resp->prenom:"" }}">
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="adresse_resp" class="col-form-label">Adresse : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control input-full" id="adresse_resp" name="adresse_resp" value="{{$resp->adresse}}" {{$resp->adresse != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="cin_resp">N° CIN : <span class="text-danger fw-bold">*</span></label>
                                <input type="number" id="cin_resp" name="cin_resp" value="{{$resp->cin}}" class="form-control" {{$resp->cin != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="nationalite_resp">Nationalité : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" id="nationalite_resp" name="nationalite_resp" value="{{$resp->nationalite}}" class="form-control" {{$resp->nationalite != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="contact1">Contact primaire : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="tel" class="form-control" id="contact1" name="contact1" value="{{$resp->contact_prim}}" {{$resp->contact_prim != null ? "disabled":"" }}>
                            </div>
                            <div class="form-check">
                                <label>Sexe : <span class="text-danger fw-bold">*</span></label><br/>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" name="sexe_resp" value="Homme" {{$resp->sexe != null && $resp->sexe=="Homme" ? "checked":"" }}>
                                    <span class="form-radio-sign">Homme</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" type="radio" name="sexe_resp" value="Femme" {{$resp->sexe != null && $resp->sexe=="Femme" ? "checked":"" }}>
                                    <span class="form-radio-sign">Femme</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" type="radio" name="sexe_resp" value="Autre" {{$resp->sexe != null && $resp->sexe=="Autre" ? "checked":"" }}>
                                    <span class="form-radio-sign">Autre</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <h3 class="text-center fw-bold">Informations professionnels</h3>
                            <hr class="mx-3">
                            <div class="form-group">
                                <label class="fw-bold" for="matricule_resp">Matricule : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control" id="matricule_resp" name="matricule_resp" value="{{$resp->matricule}}" {{$resp->matricule != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="fonct_resp">Fonction : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="text" class="form-control" id="fonct_resp" name="fonct_resp" value="{{$resp->fonction}}" {{$resp->fonction != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="date_emb_resp">Date d'embauche : <span class="text-danger fw-bold">*</span></label>
                                <input type="date" class="form-control" id="date_emb_resp" name="date_emb_resp" value="{{$resp->date_embauche}}"{{$resp->date_embauche != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="contrat_resp">Type du contrat : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="text" class="form-control" id="contrat_resp" name="contrat_resp" value="{{$resp->type_contrat}}" {{$resp->type_contrat != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="email_resp">Email : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="email" class="form-control" id="email_resp" name="email_resp" value="{{$resp->email}}" {{$resp->email != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="contact2">Contact sécondaire : </label>
                                <input type="tel" class="form-control" id="contact2" name="contact2" value="{{$resp->contact_seco}}" {{$resp->contact_seco != null ? "disabled":"" }}>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action text-right">
                    <button class="btn btn-success"><i class="fas fa-check"></i>&nbsp; Valider</button>
                    <button class="btn btn-danger"><i class="fas fa-times"></i>&nbsp; Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


