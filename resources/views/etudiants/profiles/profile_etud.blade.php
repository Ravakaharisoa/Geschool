@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-2 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="fas fa-user-cog"></i>&nbsp;&nbsp;Profil d'utilisateur</h2>
	</div>
    <hr>
</div>
<div class="row mx-2">
    <div class="col-md-12">
        <div class="card-with-nav">
            <div class="row row-nav-line mx-1">
                <ul class="nav nav-tabs nav-line nav-color-primary w-100 pl-3" role="tablist">
                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#infos" role="tab" aria-selected="true">Informations</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#comptes" role="tab" aria-selected="false">Comptes</a> </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="infos" role="tabpanel" aria-labelledby="type-tab">
                    <div class="row mt-3">
                        <div class="col-md-4 mt-3">
                            <div class="card card-profile">
                                <div class="card-header" style="background-image: url('{{asset('assets/img/blogpost.jpg')}}')">
                                    <div class="profile-picture">
                                        <div class="avatar avatar-xl">
                                            @if (Auth()->user()->photo !=null)
                                                <img src="{{asset('assets/img/users/'.Auth()->user()->photo)}}" alt="..." class="avatar-img rounded-circle">
                                            @else
                                                <img src="{{asset('assets/img/defaultuser.png')}}" alt="..." class="avatar-img rounded-circle">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body my-4">
                                    <div class="user-profile text-center my-2">
                                        <button class="btn btn-sm btn-primary my-1 update_imag_profile" id="{{$etud->id}}"><i class="fas fa-pen"></i>&nbsp; Modifier</button>
                                        <div class="my-1">{{$etud->matricule}}</div>
                                        <div class="name my-1">{{userFullName()}}</div>
                                        <div class="desc">{{$etud->classe_annuel->nom_classe}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form id="form_update_info_etud">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Nom</label>
                                            <input type="text" class="form-control" name="update_nom_etud" id="update_nom_etud" value="{{$etud->nom}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Prénom(s)</label>
                                            <input type="text" class="form-control" name="update_prenom_etud" id="update_prenom_etud" value="{{$etud->prenom}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Nationalité</label>
                                            <input type="text" class="form-control" name="update_nationalite_etud" id="update_nationalite_etud" value="{{$etud->nationalite}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Sexe</label>
                                            <select class="form-control" name="update_sexe_etud" id="update_sexe_etud">
                                                <option hidden selected></option>
                                                <option value="garcon" {{$etud->sexe != null && $etud->sexe=="garcon" ? "selected":"" }}>Garçon</option>
                                                <option value="fille" {{$etud->sexe != null && $etud->sexe=="fille" ? "selected":"" }}>Fille</option>
                                                <option value="Autre" {{$etud->sexe != null && $etud->sexe=="Autre" ? "selected":"" }}>Autre</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Contact primaire</label>
                                            <input type="tel" class="form-control" value="{{$etud->contact_prim}}" name="update_contact1_etud" id="update_contact1_etud" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Contact sécondaire</label>
                                            <input type="tel" class="form-control" name="update_contact2_etud" id="update_contact2_etud" value="{{$etud->contact_seco}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="update_email_etud" id="update_email_etud" value="{{$etud->email}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Adresse</label>
                                            <input type="text" class="form-control" value="{{$etud->adresse}}" name="update_adresse_etud" id="update_adresse_etud">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Date de Naissance</label>
                                            <input type="date" class="form-control" name="update_datenaiss_etud" id="update_datenaiss_etud" value="{{$etud->date_naissance}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Lieu de Naissance</label>
                                            <input type="text" class="form-control" name="update_lieuNaiss_etud" id="update_lieuNaiss_etud" value="{{$etud->lieu_naissance}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mt-3 mb-3">
                                    <button class="btn btn-success"><i class="far fa-save"></i>&nbsp; Enregistrer</button>
                                    <button type="reset" class="btn btn-danger"><i class="fas fa-times"></i>&nbsp; Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="comptes" role="tabpanel" aria-labelledby="marque-tab">
                    <div class="row my-3 mx-3">
                        <div class="col-md-12">
                            <div class="alert alert-info alert-dismissible w-100 text-center" role="alert">
                                <strong class="text-primary">Pour Changer votre mot de passe ,vous devez remplir les champs c-dessous !!</strong>
                                <button type="button" class="close mt--2 mr-2" data-dismiss="alert">&times;</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="lottiefiles_img">
                                <lottie-player src="{{asset('assets/img/animations/decos/change_mdp.json')}}" background="transparent"  speed="1" loop autoplay></lottie-player>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-7 m-auto">
                                <div class="form-group">
                                    <label for="">Nouveau mot de passe:</label>
                                    <input type="password" class="form-control" name="mdp_etud" id="mdp_etud">
                                </div>
                                <div class="form-group">
                                    <label for="">Confirme mot de passe:</label>
                                    <input type="password" class="form-control" name="mdp_etud" id="mdp_etud">
                                </div>
                                <div class="m-2">
                                    <button class="btn btn-success btn-block"><i class="fas fa-check"></i>&nbsp; Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/plugin/lotties/lottie-player.js')}}"></script>
<script src="{{asset('assets/js/page/user_info.js')}}"></script>
@endpush
