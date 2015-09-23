<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stuvi - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('/css/textbook.css') }}">

    @yield('css')
</head>

<body>
    {{-- Session flash messages --}}
    @include('includes.alerts')

    @yield('content')

    <script src="{{ asset('libs/html5shiv/dist/html5shiv.min.js') }}"></script>
    <script src="{{ asset('libs/respond/dest/respond.min.js') }}"></script>
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

    @yield('javascript')
</body>
</html>