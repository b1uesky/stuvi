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