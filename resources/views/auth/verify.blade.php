
@extends('layouts.app')
@section('contenu')
<div class="col-md-8 m-auto">
    <div class="row row-card-no-pd">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row">
                        <h3 class="card-title fw-bold ml-3">Vérifiez votre adresse email</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('Un nouveau lien de vérification a été envoyé à votre adresse e-mail') }}
                                </div>
                            @endif
                            <p>
                                <h4>Avant de continuer, veuillez vérifier votre e-mail pour un lien de vérification.</h4>
                            </p>
                            <p>
                                <h4>Si vous n'avez pas reçu l'e-mail, <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">cliquez ici pour en demander un autre</button>.
                                </form></h4>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
