
@extends('layouts.app_auth')
@section('contenu')
<div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center bg-white">
    <lottie-player class="lottie_player" src="{{asset('assets/img/animations/decos/oublie_mdp.json')}}" background="transparent" speed="1" loop autoplay></lottie-player>
</div>
<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
    <div class="container container-login container-transparent animated fadeIn">
        <div class="logo">
            <img src="{{asset('assets/img/animations/geschool.png')}}" alt="logo" srcset="">
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <hr class="mx-3">
        <h3 class="text-center">Mot de passe oublié?</h3>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
           <div class="login-form mx-2">
               <div class="form-group mx-4">
                   <label for="email" class="placeholder"><b>Adresse Email</b></label>
                   <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                   @error('email')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                   @enderror
               </div>
               <div class="form-group mb-3 mx-4">
                   <button type="submit" class="btn btn-primary mt-3 btn-block mb-3 mt-sm-0 fw-bold">Supprimer de mot de passe</button>
                   <a href="{{ route('login') }}" class="text-default d-block"><i class="fas fa-arrow-left"></i> Retour à la page de connexion</a>
               </div>

           </div>
       </form>
    </div>
</div>
@endsection
