<footer class="footer-distributed bg-white">

    <div class="container">
        <div class="row">
            <ul class="footer-links col-xs-4 text-left">
                <li><a href="{{ url('/about') }}" name="about">About</a></li>
                <li><a href="{{ url('/faq/general') }}" name="FAQ">FAQ</a></li>
                <li class="nobullet"><a href="{{ url('/contact') }}" name="contact">Contact</a></li>
                {{--<a href="{{ url('/sitemap') }}" name="sitemap">Sitemap</a>--}}
            </ul>

            <div class="social-links col-xs-4 text-center">
                <!-- Uses font-awesome.css -->
                <a href="https://www.facebook.com/StuviBoston" target="_blank" name="facebook">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="https://twitter.com/StuviBoston" target="_blank" name="twitter">
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="https://www.linkedin.com/company/stuvi" target="_blank" name="linkedin">
                    <i class="fa fa-linkedin"></i>
                </a>
            </div>

            <ul class="company-info col-xs-4 text-right">
                <li><span class="copyright">&copy; 2015 Stuvi</span></li>
                <li><a href="#" name="terms">Terms</a></li>
                <li class="nobullet"><a href="#" name="privacy">Privacy</a></li>
            </ul>
        </div>

    </div>

</footer>
<!-- END FOOTER -->