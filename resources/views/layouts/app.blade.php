<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ config('app.name', 'GeSchool') }}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/img/animations/icon.svg')}}" type="image/x-icon" />

    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset("assets/css/fonts.min.css") }}']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/geschool2.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
</head>
<body>
	<div class="wrapper horizontal-layout-2">

		<div class="main-header" data-background-color="blue">
			<div class="nav-top">
				<div class="container d-flex flex-row">
					<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon">
							<i class="icon-menu"></i>
						</span>
					</button>
					<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
					<a href="index.html" class="logo d-flex align-items-center">
                        <img src="{{asset('assets/img/animations/logo.png')}}" alt="navbar brand" class="navbar-brand">
					</a>
					<nav class="navbar navbar-header navbar-expand-lg p-0">

						<div class="container-fluid p-0">
							<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
								<li class="nav-item dropdown hidden-caret">
									<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
										<div class="avatar-sm">
                                            @if (Auth()->user()->photo !=null)
                                                <img src="{{asset('assets/img/users/'.Auth()->user()->photo)}}" alt="..." class="avatar-img rounded-circle">
                                            @else
                                                <img src="{{asset('assets/img/defaultuser.png')}}" alt="..." class="avatar-img rounded-circle">
                                            @endif
										</div>
									</a>
									<ul class="dropdown-menu dropdown-user animated fadeIn">
										<div class="dropdown-user-scroll scrollbar-outer">
											<li>
												<div class="user-box">
													<div class="avatar-lg">
                                                        @if (Auth()->user()->photo !=null)
                                                            <img src="{{asset('assets/img/users/'.Auth()->user()->photo)}}" alt="image profile" class="avatar-img rounded">
                                                        @else
                                                            <img src="{{asset('assets/img/defaultuser.png')}}" alt="image profile" class="avatar-img rounded">
                                                        @endif
                                                    </div>
													<div class="u-text">
														<h4>{{userFullName()}}</h4>
														<p class="text-muted">{{Auth::user()->email}}</p>
													</div>
												</div>
											</li>
											<li>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                    <i class="fas fa-sign-out-alt"></i> &nbsp;&nbsp;Se déconnecter
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
											</li>
										</div>
									</ul>
								</li>
							</ul>
						</div>
					</nav>
				</div>
			</div>
		</div>

		<div class="main-panel">
			<div class="container">
				<div class="page-inner">
					@yield('contenu')
				</div>
			</div>
		</div>
		<footer class="footer">
			<div class="container">
				<nav class="pull-left">
					<ul class="nav">
						<li class="nav-item">
							<a class="nav-link" href="http://localhost:8000/">
								Ge-School
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">
								Aide
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">
								Licenses
							</a>
						</li>
					</ul>
				</nav>
				<div class="copyright ml-auto">
					2023, made with <i class="fa fa-heart heart text-danger"></i> by <a href="http://localhost:8000/">Mariah</a>
				</div>
			</div>
		</footer>

	</div>

	<script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{asset('assets/js/core/popper.min.js')}}"></script>
	<script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<script src="{{asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
	<script src="{{asset('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js')}}"></script>
	<script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/js/plugin/jquery.validate/jquery.validate.min.js')}}"></script>
	<script src="{{asset('assets/js/geschool2.min.js')}}"></script>
    <script src="{{asset('assets/js/page/user_info.js')}}"></script>
</body>
</html>
