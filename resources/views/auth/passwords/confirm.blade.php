@extends('layouts.app_auth')
@section('contenu')
<div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center bg-white">
    <lottie-player class="lottie_player" src="{{asset('assets/img/animations/decos/confirm_mdp.json')}}" background="transparent" speed="1" loop autoplay></lottie-player>
</div>
<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
    <div class="container container-login container-transparent animated fadeIn">
        <div class="logo">
            <img src="{{asset('assets/img/animations/geschool.png')}}" alt="logo" srcset="">
        </div>
        <hr class="mx-3">
        <h3 class="text-center">Confirmé mot de passe</h3>
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mot de passe') }}</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Confirmer mot de passe') }}
                    </button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
