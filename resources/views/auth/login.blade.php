@extends('layouts.app_auth')

@section('contenu')
<div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center bg-white">
    <lottie-player class="lottie_player" src="{{asset('assets/img/animations/decos/inscrire.json')}}" background="transparent" speed="1" loop autoplay></lottie-player>
    {{-- <lottie-player src="{{asset('assets/img/animations/login.json')}}" background="transparent"  speed="1"  style="width: 300px; height: 300px;" loop controls autoplay></lottie-player> --}}
</div>
<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
    <div class="container container-login container-transparent animated fadeIn">
        <div class="logo">
            <img src="{{asset('assets/img/animations/geschool.png')}}" alt="logo" srcset="">
        </div>
        <hr class="mx-3">
        <form method="POST" action="{{ route('login') }}">
             @csrf
            <div class="login-form">
                <div class="form-group">
                    <label for="email" class="placeholder"><b>Adresse Email</b></label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="placeholder"><b>Mot de passe</b></label>
                    <div class="position-relative">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
                        <div class="show-password">
                            <i class="fas fa-eye eyes"></i>
                            <i class="fas fa-eye-slash eye_slash"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group form-action-d-flex mb-3">
                    @if (Route::has('password.request'))
                        <a class="link float-right text-primary" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Se connecter</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
