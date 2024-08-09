@extends('layouts.app_page')
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <h3 class="fw-bold">Modifier les informations du Ge-School</h3>
            <a href="{{route('ecole')}}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-circle-left"></i> Retour</a>
        </div>
        <hr class="mx-2 my-2">
        @if(session()->has('error'))
            <div class="alert alert-danger text-danger text-center">
                <button type="button" class="close text-danger" data-dismiss="alert">&times;</button>
                <b class="text-center">{{session()->get('error')}}</b>
            </div>
        @elseif(session()->has('warning'))
            <div class="alert alert-warning text-warning text-center">
                <button type="button" class="close text-warning" data-dismiss="alert">&times;</button>
                <b class="text-center">{{session()->get('warning')}}</b>
            </div>
        @endif
        <form method="POST" class="form_update_ecole" action="{{route('update_ecole',$ecole->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group form-show-validation text-center">
                    <label class="fw-bold">Logo<span class="required-label">*</span></label>
                    <div class="input-file input-file-image">
                        <img class="img-upload-preview img-circle m-auto" width="100" height="100" src="{{asset('assets/img/ecoles/'.$ecole->logo)}}" alt="preview">
                        <input type="file" class="form-control form-control-file" id="logo_ecole_update" name="logo_ecole_update" accept="image/*" value="{{asset('assets/img/ecoles/'.$ecole->logo)}}">
                            @error('logo_ecole_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        <label for="logo_ecole_update" class="btn btn-primary btn-round btn-sm"><i class="fa fa-file-image"></i> Choisir image</label>
                    </div>
                </div>
                <div class="separator-solid"></div>
                <div class="row col-md-12 mx-2">
                    <div class="col-md-6">
                        <div class="form-group form-show-validation">
                            <label for="nom_ecole_update" class="fw-bold">Nom <span class="required-label">*</span></label>
                            <input type="text" class="form-control {{$errors->has('nom_ecole_update')? "is-invalid":""}}" name="nom_ecole_update" value="{{$ecole->nom}}" required>
                            @error('nom_ecole_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="slogan_update" class="fw-bold">Slogan <span class="required-label">*</span></label>
                            <input type="text" class="form-control {{$errors->has('slogan_update')? "is-invalid":""}}" name="slogan_update" value="{{$ecole->slogan}}" required>
                            @error('slogan_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="ouverture_update" class="fw-bold">Date ouverture <span class="required-label">*</span></label>
                            <input type="date" class="form-control {{$errors->has('ouverture_update')? "is-invalid":""}}" name="ouverture_update" value="{{$ecole->date_ouverture}}" required>
                            @error('ouverture_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="heure_ouverture_update" class="fw-bold">Heure ouverture <span class="required-label">*</span></label>
                            <input type="time" class="form-control {{$errors->has('heure_ouverture_update')? "is-invalid":""}}" name="heure_ouverture_update" value="{{$ecole->heure_ouverture}}" required>
                            @error('heure_ouverture_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-show-validation">
                            <label for="email_ecole_update" class="fw-bold">Adresse email<span class="required-label">*</span></label>
                            <input type="email" class="form-control {{$errors->has('email_ecole_update')? "is-invalid":""}}" name="email_ecole_update" value="{{$ecole->email}}" required>
                            @error('email_ecole_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="contact_1_update" class="fw-bold">Contact primaire <span class="required-label">*</span></label>
                            <input type="tel" class="form-control {{$errors->has('contact_1_update')? "is-invalid":""}}" name="contact_1_update" value="{{$ecole->phone1}}">
                            @error('contact_1_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="contact_2_update" class="fw-bold">Contact sécondaire</label>
                            <input type="tel" class="form-control"  name="contact_2_update" value="{{$ecole->phone2 != null?$ecole->phone2:""}}">
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="heure_fermeture_update" class="fw-bold">Heure fermeture<span class="required-label">*</span></label>
                            <input type="time" class="form-control {{$errors->has('heure_fermeture_update')? "is-invalid":""}}" name="heure_fermeture_update" value="{{$ecole->heure_fermeture}}" required>
                            @error('heure_fermeture_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mx-5">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Annuler</button>
                <button type="submit" id="edit_btn_ecole" name="submit" class="btn btn-success btn-sm">Valider</button>
            </div>
        </form>
    </div>
</div>
@endsection

