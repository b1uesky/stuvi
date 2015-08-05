@section('flash-message')
        <!-- different icon and bg color depending on alert. add to other pages??? -->
@if (Session::has('message'))
    @if (Session::get('alert-class') == 'alert-danger' or Session::get('alert-class') == 'alert-warning')
        <div class="container {{ Session::get('alert-class') }}" id="message-cont"
             xmlns="http://www.w3.org/1999/html">
            <div class="flash-message" id="message"><i
                        class="fa fa-exclamation-triangle"></i> {{ Session::get('message') }}</div>
        </div>
    @elseif (Session::get('alert-class') == 'alert-info')
        <div class="container {{ Session::get('alert-class') }}" id="message-cont"
             xmlns="http://www.w3.org/1999/html">
            <div class="flash-message" id="message"><i class="fa fa-info-circle"></i> {{ Session::get('message') }}
            </div>
        </div>
    @else
        <div class="container {{ Session::get('alert-class') }}" id="message-cont"
             xmlns="http://www.w3.org/1999/html">
            <div class="flash-message" id="message"><i
                        class="fa fa-check-square-o"></i> {{ Session::get('message') }}</div>
        </div>
    @endif
@endif

@show