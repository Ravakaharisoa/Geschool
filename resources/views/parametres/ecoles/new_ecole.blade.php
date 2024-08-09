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
        <form method="POST" action="{{route('add_ecole')}}" class="form_add_ecole" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group form-show-validation text-center">
                    <label class="fw-bold">Logo<span class="required-label">*</span></label>
                    <div class="input-file input-file-image">
                        <img class="img-upload-preview img-circle m-auto" width="100" height="100" src="http://placehold.it/100x100" alt="preview">
                        <input type="file" class="form-control form-control-file" id="logo_ecole" name="logo_ecole" accept="image/*">
                            @error('logo_ecole')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        <label for="logo_ecole" class="btn btn-primary btn-round btn-sm"><i class="fa fa-file-image"></i> Choisir image</label>
                    </div>
                </div>
                <div class="separator-solid"></div>
                <div class="row col-md-12 mx-2">
                    <div class="col-md-6">
                        <div class="form-group form-show-validation">
                            <label for="nom_ecole" class="fw-bold">Nom <span class="required-label">*</span></label>
                            <input type="text" class="form-control {{$errors->has('nom_ecole')? "is-invalid":""}}" name="nom_ecole" value="{{old('nom_ecole')}}">
                            @error('nom_ecole')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="slogan" class="fw-bold">Slogan <span class="required-label">*</span></label>
                            <input type="text" class="form-control {{$errors->has('slogan')? "is-invalid":""}}" name="slogan" value="{{old('slogan')}}">
                            @error('slogan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="ouverture" class="fw-bold">Date ouverture<span class="required-label">*</span></label>
                            <input type="date" class="form-control {{$errors->has('ouverture')? "is-invalid":""}}" name="ouverture" value="{{old('ouverture')}}">
                            @error('ouverture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="heure_ouverture" class="fw-bold">Heure ouverture<span class="required-label">*</span></label>
                            <input type="time" class="form-control {{$errors->has('heure_ouverture')? "is-invalid":""}}" name="heure_ouverture" value="{{old('heure_ouverture')}}">
                            @error('heure_ouverture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-show-validation">
                            <label for="email_ecole" class="fw-bold">Adresse email<span class="required-label">*</span></label>
                            <input type="email" class="form-control {{$errors->has('email_ecole')? "is-invalid":""}}" name="email_ecole" value="{{old('email_ecole')}}">
                            @error('email_ecole')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="contact_1" class="fw-bold">Contact primaire <span class="required-label">*</span></label>
                            <input type="tel" class="form-control {{$errors->has('contact_1')? "is-invalid":""}}" name="contact_1" value="{{old('contact_1')}}">
                            @error('contact_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="contact_2" class="fw-bold">Contact sécondaire</label>
                            <input type="tel" class="form-control"  name="contact_2" value="{{old('contact_2')}}">
                        </div>
                        <div class="form-group form-show-validation">
                            <label for="heure_fermeture" class="fw-bold">Heure fermeture<span class="required-label">*</span></label>
                            <input type="time" class="form-control {{$errors->has('heure_fermeture')? "is-invalid":""}}" name="heure_fermeture" value="{{old('heure_fermeture')}}">
                            @error('heure_fermeture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mx-5">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Annuler</button>
                <button type="submit" name="submit" class="btn btn-success btn-sm btn_add_ecole">Valider</button>
            </div>
        </form>
    </div>
</div>
@endsection

