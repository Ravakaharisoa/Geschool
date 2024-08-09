<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/demos.css') }}">
</head>
<body>
    <div class="wrapper">
        <div class="main-panel">
            @yield('contents')
        </div>
    </div>
</body>
</html>
