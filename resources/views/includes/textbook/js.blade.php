<script src="{{ asset('libs/html5shiv/dist/html5shiv.min.js') }}"></script>
<script src="{{ asset('libs/respond/dest/respond.min.js') }}"></script>
<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}"></script>
<script src="{{ asset('libs/sortable/js/sortable.min.js') }}"></script>
<script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js') }}"></script>
<script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js') }}"></script>

<script src="{{ asset('js/auth/login.js') }}"></script>
<script src="{{ asset('js/modal.js') }}"></script>
<script src="{{ asset('js/alert.js') }}"></script>

@if(\App::environment('production'))
    <script src="{{ asset('js/googleanalytics.js') }}"></script>
@endif

@yield('javascript')