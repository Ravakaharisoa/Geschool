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
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/geschool.css') }}">
    {{-- <link rel="stylesheet" href="{{mix("css/app.css")}}"> --}}
</head>

<body>
    <div class="wrapper">
        @include('masters.header')
        @can('isDirecteur')
            @include('masters.sidebar')
        @endcan
        @can('isResponsable')
            @include('masters.sidebar_resp')
        @endcan

        @can('isProfesseur')
            @include('masters.sidebar_prof')
        @endcan

        @can('isEtudiant')
            @include('masters.sidebar_etud')
        @endcan

        <div class="main-panel">
            <div class="content">
                <div class="page-inner mt-5">
                    <div class="page-header {{routeName('admin.parametres.','show')}}">
                        <h4 class="page-title">
                        </h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="{{ route('home') }}">
                                    <i class="flaticon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                Paramètres
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                {{$title}}
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @yield('contents')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal utilisé dans toute application --}}
    <div class="modal fade modalApp" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal_content">

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery_ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/sortable/sortable.min.js') }}"></script>
    <script src="{{ asset('assets/prism-normalize-whitespace.min.js') }}"></script>
    <script src="{{asset('assets/js/geschool.min.js')}}"></script>
    <script src="{{asset('assets/js/setting-demo.js')}}"></script>
    <script src="{{mix("js/app.js")}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.validate/jquery.validate.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
