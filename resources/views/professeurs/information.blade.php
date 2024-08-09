@extends('layouts.app')
@section('contenu')
<div class="row">
    <div class="col-md-11 m-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title fw-bold"><i class="far fa-address-card"></i>&nbsp; Vos Informations</div>
            </div>
            <form  id="formulaire_prof" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="form-group form-show-validation row">
                            <label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 fw-bold text-right">Photo :<span class="required-label">*</span></label>
                            <div class="col-lg-7 col-md-9 col-sm-8">
                                <div class="input-file input-file-image">
                                    <img class="img-upload-preview img-circle" width="100" height="100" src="{{asset('assets/img/defaultuser.png')}}" alt="preview">
                                    <input type="file" class="form-control form-control-file" id="uploadImg_prof" name="uploadImg_prof" accept="image/*" required >
                                    <label for="uploadImg_prof" class="btn btn-primary btn-round btn-sm"><i class="fa fa-file-image"></i> Choisir image</label>
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
                                <label class="fw-bold" for="nom_prof">Nom : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control" id="nom_prof" name="nom_prof" value="{{$prof->nom}}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="prenom_prof">Prénom : </label>
                                <input type="text" class="form-control" id="prenom_prof" name="prenom_prof" {{$prof->prenom != null ? "disabled":"" }} value="{{$prof->prenom != null ? $prof->prenom:"" }}">
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="adresse_prof" class="col-form-label">Adresse : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="adresse_prof" class="form-control input-full" id="adresse_prof" value="{{$prof->adresse}}" {{$prof->adresse != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="cin_prof">N° CIN : <span class="text-danger fw-bold">*</span></label>
                                <input type="number" name="cin_prof" id="cin_prof" value="{{$prof->cin}}" class="form-control" {{$prof->cin != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="nationalite_prof">Nationalité : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="nationalite_prof" id="nationalite_prof" value="{{$prof->nationalite}}" class="form-control" {{$prof->nationalite != null ? "disabled":"" }}>
                            </div>
                            <div class="form-check">
                                <label>Sexe : <span class="text-danger fw-bold">*</span></label><br/>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" name="sexe_prof" value="Homme" {{$prof->sexe != null && $prof->sexe=="Homme" ? "checked":"" }}>
                                    <span class="form-radio-sign">Homme</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" type="radio" name="sexe_prof" value="Femme" {{$prof->sexe != null && $prof->sexe=="Femme" ? "checked":"" }}>
                                    <span class="form-radio-sign">Femme</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" type="radio" name="sexe_prof" value="Autre" {{$prof->sexe != null && $prof->sexe=="Autre" ? "checked":"" }}>
                                    <span class="form-radio-sign">Autre</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <h3 class="text-center fw-bold">Informations professionnels</h3>
                            <hr class="mx-3">
                            <div class="form-group">
                                <label class="fw-bold" for="matricule_prof">Matricule : <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="matricule_prof" class="form-control" id="matricule_prof" value="{{$prof->matricule}}" {{$prof->matricule != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="date_emb_prof">Date d'embauche : <span class="text-danger fw-bold">*</span></label>
                                <input type="date" name="date_emb_prof" class="form-control" id="date_emb_prof" value="{{$prof->date_embauche}}"{{$prof->date_embauche != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="contrat_prof">Type du contrat : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="text" name="contrat_prof" class="form-control" id="contrat_prof" value="{{$prof->type_contrat}}" {{$prof->type_contrat != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="email_prof">Email : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="email" name="email_prof" class="form-control" id="email_prof" value="{{$prof->email}}" {{$prof->email != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="contact1_prof">Contact primaire : <span class="text-danger fw-bold">*</span></label></label>
                                <input type="tel" name="contact1_prof" class="form-control" id="contact1_prof" value="{{$prof->contact1}}" {{$prof->contact1 != null ? "disabled":"" }}>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="contact2_prof">Contact sécondaire : </label>
                                <input type="tel" name="contact2_prof" class="form-control" id="contact2_prof" value="{{$prof->contact2}}" {{$prof->contact2 != null ? "disabled":"" }}>
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
@push('scripts')
    <script src="{{asset('assets/js/page/user_info.js')}}"></script>
@endpush
