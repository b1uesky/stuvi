<!DOCTYPE html>
<html lang="en">

@include('includes.textbook.head')

<body>

<div class="container-wrapper">

    @section('textbook-header')
        {{-- Nav bar --}}
        {{-- home.blade.php overwrites this section --}}
        @include('includes.textbook.header')
    @show

    {{-- Session flash messages --}}
    @include('includes.alerts')

    {{-- Page content --}}
    @yield('content')

</div>

@include('includes.modal.login-signup')

{{-- footer --}}
@include('includes.textbook.footer')

{{-- js files --}}
<script src="{{ asset('build/js/textbook.js') }}"></script>

@if(\App::environment('production'))
    {{-- Google analytics tracking code --}}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-66142383-1', 'auto');
        ga('send', 'pageview');
    </script>
@endif

@yield('javascript')

</body>

</html>
