{{--
  -- app.blade for Stuvi.
  -- Contains the code for the navbar and footer
  -- May 2015
  -- Please read the doc for blade template: http://laravel.com/docs/5.1/blade
  --}}

<!DOCTYPE html>
<html lang="en">

@include('includes.textbook.head')

<body>
{{-- Nav bar --}}
@include('includes.textbook.header')

{{-- Page content --}}
@yield('content')

{{-- Page modals --}}
@yield('modals')

{{-- Required modals --}}
<?php $url = Request::url() ?>
@if(Auth::check())
  <?php $cartQty = Auth::user()->cart->quantity ?>
@endif

        <!-- login modal -->
@if (Auth::guest() && !($url === url('/') || $url === url('/home')))
  @include('auth.login-signup-modal')
@endif

@if(Auth::check())
  <!-- Empty Cart Modal -->
  @if($cartQty == 0)
    @include('cart.empty-cart-modal')
  @endif
@endif


{{--loader shade--}}
@include('loader')
@include('includes.textbook.footer')

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/loader.js') }}"></script>

@if(Auth::guest())
  {{-- FormValidation --}}
  <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js')}}"></script>
  <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/auth/login.js')}}"></script>
@endif

@if(\App::environment('production'))
  <script src="{{ asset('js/googleanalytics.js') }}"></script>
@endif

  @yield('javascript')
</body>

</html>
