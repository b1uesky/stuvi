<footer class="footer-distributed">

    <div class="container">
        <div class="row">
            <ul class="footer-links col-sm-4 text-center">
                <li><a href="{{ url('/about') }}" name="about">About</a></li>
                <li><a href="{{ url('/faq/general') }}" name="FAQ">FAQ</a></li>
                <li class="nobullet"><a href="{{ url('/contact') }}" name="contact">Contact</a></li>
                {{--<a href="{{ url('/sitemap') }}" name="sitemap">Sitemap</a>--}}
            </ul>

            <ul class="social-links col-sm-4 text-center">
                <li>
                    <a href="https://www.facebook.com/StuviBoston" target="_blank" name="facebook">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>

                <li>
                    <a href="https://twitter.com/StuviBoston" target="_blank" name="twitter">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>

                <li>
                    <a href="https://www.linkedin.com/company/stuvi" target="_blank" name="linkedin">
                        <i class="fa fa-linkedin"></i>
                    </a>
                </li>
            </ul>

            <ul class="company-info col-sm-4 text-center">
                <li><span class="copyright">&copy; 2015 Stuvi, LLC.</span></li>
                <li><a href="{{url('tos')}}" name="terms" >Terms</a></li>
                <li class="nobullet"><a href="{{url('/privacy')}}" name="privacy">Privacy</a></li>
            </ul>
        </div>
    </div>

</footer>
<!-- END FOOTER -->
