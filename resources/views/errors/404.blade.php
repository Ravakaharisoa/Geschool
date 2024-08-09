@extends('layouts.app_error')
@section('contenu')
<div class="wrapper not-found">
    <lottie-player src="{{asset('assets/img/animations/decos/autre404.json')}}" background="transparent"  speed="1"  style="width: 70%; height: 70%;" loop autoplay></lottie-player>
	<a href="{{route('home')}}" class="btn btn-primary btn-back-home mt-4 animated fadeInUp">
		<span class="btn-label mr-2">
			<i class="flaticon-home"></i>
		</span>
		Retour a la page d'accueil
	</a>
</div>
@endsection
