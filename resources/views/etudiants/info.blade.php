@extends('layouts.app')
@section('contenu')
<div class="row">
    <div class="col-md-11 m-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title fw-bold"><i class="far fa-address-card"></i>&nbsp; Vos informations</div>
            </div>
            <form id="formulaire_etud_info">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="form-group form-show-validation row">
                            <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 fw-bold text-right">Photo :<span class="required-label">*</span></label>
                            <div class="col-lg-7 col-md-9 col-sm-8">
                                <div class="input-file input-file-image">
                                    <img class="img-upload-preview img-circle" width="100" height="100" src="{{asset('assets/img/defaultuser.png')}}" alt="preview">
                                    <input type="file" class="form-control form-control-file" id="uploadImg_etud" name="uploadImg_etud" accept="image/*" required >
                                    <label for="uploadImg_etud" class="btn btn-primary btn-round btn-sm"><i class="fa fa-file-image"></i> Choisir image</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator-solid"></div>
                    <h3 class="text-center fw-bold">Informations Personnelles</h3>
                    <div class="row col-md-12">
                        <div class="col-md-6 col-lg-6">
                            <hr class="mx-3">
                            <div class="form-group">
                                <label class="fw-bold" for="nom_etud">Nom : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control" id="nom_etud" name="nom_etud" value="{{$etud->nom}}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="prenom_etud">Prénom : </label>
                                <input type="text" class="form-control" id="prenom_etud" name="prenom_etud" {{$etud->prenom != null ? "disabled":"" }} value="{{$etud->prenom != null ? $etud->prenom:"" }}">
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="date_naiss">Date de naissance : <span class="text-danger fw-bold">*</span></label>
                                <input type="date" class="form-control" name="date_naiss" id="date_naiss" value="{{$etud->date_naissance}}"{{$etud->date_naissance != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="adresse_etud" class="col-form-label">Adresse : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control input-full" name="adresse_etud" id="adresse_etud" value="{{$etud->adresse}}" {{$etud->adresse != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="nationalite_etud">Nationalité : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" id="nationalite_etud" name="nationalite_etud" value="{{$etud->nationalite}}" class="form-control" {{$etud->nationalite != null ? "disabled":"" }}>
                            </div>
                            <div class="form-check">
                                <label>Sexe : <span class="text-danger fw-bold">*</span></label><br/>
                                <label class="form-radio-label">
                                    <input class="form-radio-input sexe_etud" type="radio" name="sexe_etud" value="{{$etud->sexe}}" {{$etud->sexe != null && $etud->sexe=="fille" ? "checked":"" }}>
                                    <span class="form-radio-sign">Fille</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input sexe_etud" type="radio" name="sexe_etud" value="{{$etud->sexe}}" {{$etud->sexe != null && $etud->sexe=="garcon" ? "checked":"" }}>
                                    <span class="form-radio-sign">Garçon</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input sexe_etud" type="radio" name="sexe_etud" value="{{$etud->sexe}}" {{$etud->sexe != null && $etud->sexe=="Autre" ? "checked":"" }}>
                                    <span class="form-radio-sign">Autre</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <hr class="mx-3">
                            <div class="form-group">
                                <label class="fw-bold" for="matricule_etud">Matricule : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control" id="matricule_etud" value="{{$etud->matricule}}" {{$etud->matricule != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="lieu_naiss">Lieu de naissance : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="text" class="form-control" name="lieu_naiss" id="lieu_naiss" value="{{$etud->lieu_naissance}}" {{$etud->lieu_naissance != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="email_etud">Email : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="email" class="form-control" id="email_etud" value="{{$etud->email}}" {{$etud->email != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="maladie_etud">Maladie : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="email" class="form-control" id="maladie_etud" value="{{$etud->maladie}}" {{$etud->maladie != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="contact1">Contact primaire : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="tel" class="form-control" id="contact1" value="{{$etud->contact_prim}}" {{$etud->contact_prim != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="contact2">Contact sécondaire : </label>
                                <input type="tel" class="form-control" id="contact2" value="{{$etud->contact_seco}}" {{$etud->contact_seco != null ? "disabled":"" }}>
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
