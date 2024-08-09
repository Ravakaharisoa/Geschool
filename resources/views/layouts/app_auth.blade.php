
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>{{ config('app.name', 'GeSchool') }}</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" href="{{ asset('assets/img/animations/icon.svg')}}" type="image/x-icon"/>

	{{-- Fonts and icons --}}
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset("assets/css/fonts.min.css")}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	{{-- CSS Files --}}
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/geschool.css') }}">
</head>
<body class="login">
	<div class="wrapper wrapper-login wrapper-login-full p-2">
        @yield('contenu')
	</div>
	<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>
	<script src="{{ asset('assets/js/geschool.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/lotties/lottie-player.js')}}"></script>
	<script>
		$(document).ready(function(){
			$('.eyes').hide();
			$('.show-password').on('click',function(event){
				event.preventDefault();
				var inputType = $('#password').attr('type');
				if(inputType =='password'){
					$('.eyes').hide();
					$('.eye_slash').show();
				}else if(inputType == 'text'){
					$('.eye_slash').hide();
					$('.eyes').show();
				}
			});

			$('input').on("focus", function(){
				$('.show-password').find('i').css('color','#6aa1ef');
			});

		});
	</script>
</body>
</html>
