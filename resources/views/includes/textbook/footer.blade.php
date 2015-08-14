<!-- FOOTER. See footer styling at footer-distributed.css -->

<footer class="footer-distributed">
    {{--<div class="row">
        <hr style="    border: 0;height: 2px;background: #333; background-image: linear-gradient(to right, #ccc, #f16521, #ccc);">
    </div>--}}

    <!-- Social Media -->
    <div class="footer-right">
        <!-- Uses font-awesome.css -->
        <a class="social" href="https://www.facebook.com/StuviBoston" target="_blank" name="facebook">
            <i class="fa fa-facebook"></i>
        </a>
        <a class="social" href="https://twitter.com/StuviBoston" target="_blank" name="twitter">
            <i class="fa fa-twitter"></i>
        </a>
        <a class="social" href="https://www.linkedin.com/company/stuvi" target="_blank" name="linkedin">
            <i class="fa fa-linkedin"></i>
        </a>
    </div>

    <div class="footer-left">

        <p class="footer-links">
            <a class="footer-link" href="{{url('/home')}}" name="home">Home</a>
            ·
            <a class="footer-link"  href="{{url('/textbook')}}" name="textbooks">Textbooks</a>
{{--            ·
            <a class="footer-link"  href="{{url('/coming')}}">Housing</a>
            ·
            <a class="footer-link" href="{{url('/coming')}}">Clubs</a>
            ·
            <a class="footer-link" href="{{url('/coming')}}">Groups</a>--}}
            ·
            <a class="footer-link"  href="{{ url('/about') }}" name="about">About</a>
            ·
            <a class="footer-link"  href="{{ url('/contact') }}" name="contact">Contact</a>
            ·
            <a class="footer-link" href="{{ url('/faq/general') }}" name="FAQ">FAQ</a>
            ·
            <a class="footer-link" href="{{ url('/sitemap') }}" name="sitemap">Sitemap</a>
        </p>
        <hr>
        <p>&copy; Stuvi, LLC. 2015</p>
    </div>

</footer>
<!-- END FOOTER -->