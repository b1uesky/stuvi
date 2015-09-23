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
@include('includes.textbook.js')

</body>

</html>
