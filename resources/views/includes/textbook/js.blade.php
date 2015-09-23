<script src="{{ asset('build/js/textbook.js') }}"></script>

<script src="{{ asset('js/auth/login.js') }}"></script>
<script src="{{ asset('js/modal.js') }}"></script>
<script src="{{ asset('js/alert.js') }}"></script>

@if(\App::environment('production'))
    <script src="{{ asset('js/googleanalytics.js') }}"></script>
@endif

@yield('javascript')