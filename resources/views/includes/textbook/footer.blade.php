<!-- FOOTER. See footer styling at footer-distributed.css -->

<footer class="footer-distributed">
    {{--<div class="row">
        <hr style="    border: 0;height: 2px;background: #333; background-image: linear-gradient(to right, #ccc, #f16521, #ccc);">
    </div>--}}

    <!-- Social Media -->
    <div class="footer-right">
        <!-- Uses font-awesome.css -->
        <a class="social" href="https://www.facebook.com/StuviBoston" target="_blank"><i class="fa fa-facebook"></i></a>
        <a class="social" href="https://twitter.com/StuviBoston" target="_blank"><i class="fa fa-twitter"></i></a>
        <a class="social" href="https://www.linkedin.com/company/stuvi?trk=biz-companies-cym" target="_blank"><i class="fa fa-linkedin"></i></a>
        {{--<a class="social" href="#"><i class="fa fa-github"></i></a>--}}

    </div>

    <div class="footer-left">

        <p class="footer-links">
            <a class="footer-link" href="{{url('/home')}}">Home</a>
            ·
            <a class="footer-link"  href="{{url('/textbook')}}">Textbooks</a>
            ·
            <a class="footer-link"  href="{{url('/coming')}}">Housing</a>
            ·
            <a class="footer-link" href="{{url('/coming')}}">Clubs</a>
            ·
            <a class="footer-link" href="{{url('/coming')}}">Groups</a>
            ·
            <a class="footer-link"  href="{{ url('/about') }}">About</a>
            ·
            <a class="footer-link"  href="{{ url('/contact') }}">Contact</a>
            ·
            <a class="footer-link" href="{{ url('/faq') }}">FAQ</a>
        </p>
        <hr>
        <p>&copy; Stuvi, LLC. 2015</p>
    </div>

</footer>
<!-- END FOOTER -->