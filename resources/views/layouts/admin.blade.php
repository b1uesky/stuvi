<!DOCTYPE html>
<html>

@section('title', 'Home')

@include('includes.admin.head')

<body>

@include('includes.admin.header')

{{-- Session flash messages --}}
@include('includes.alerts')

<div class="container-fluid">
    <div class="row page-content">
        <div class="col-md-2">
            @include('includes.admin.menu')
        </div>

        <div class="col-md-10">
            @yield('content')
        </div>
    </div>
</div>

@include('includes.admin.footer')

<script src="{{ asset('build/js/core.js') }}"></script>

</body>
</html>
