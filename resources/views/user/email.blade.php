{{--User Email page--}}


@extends('app')
@section('title', 'Email - '.Auth::user()->first_name.' '.Auth::user()->last_name )

@section('css')
    <link href="{{ asset('/css/user_profile.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- User template has the second nav bar and the profile side bar -->
    @include('user-template')
            <div class="col-md-9">
                <div class="profile-content">
                    <!-- right box -->
                    <div class="container col-xs-12 col-md-12" id = "email-details">
                        <h3>Email</h3>
                        {{-- Email List --}}
                        <p>Note: Stuvi will send all notification email to your primary email.</p>
                        <table class="table table-hover">
                            @foreach ($emails as $email)
                                <tr>
                                    <td><strong>{{ $email->email_address }}</strong></td>
                                    <td>
                                        @if (Auth::user()->primary_email_id == $email->id)
                                            Primary
                                        @else
                                            <form action="{{ url('/user/email/set/primary') }}" method="post">
                                                {!! csrf_field() !!}
                                                <input type="hidden" value="{{ $email->id }}">
                                                <input type="submit" class="btn primary-btn" value="Set as primary">
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ url('/user/email/remove') }}" method="post">
                                            {!! csrf_field() !!}
                                            <input type="hidden" value="{{ $email->id }}">
                                            <input type="submit" class="btn primary-btn" value="Remove">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{-- Add an email --}}
                        <form action="{{ url('/user/email/add') }}" method="post">
                            {!! csrf_field() !!}
                            <label>Add an email</label>
                            <div class="form-group form-inline">
                                <input type="email" name="email" value="{{ old('email') }}">
                                <button type="submit" class="btn btn-default">Add</button>
                            </div>
                            @if (Session::has('email_validation_error'))
                                <div class="container" id="message-cont" xmlns="http://www.w3.org/1999/html">
                                    @foreach (Session::get('email_validation_error')->get('email') as $err)
                                        <div class="flash-message" id="message" >{{ $err }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </form>
                    </div>
                 </div>
            </div>
<!-- needed to end user bar -->
        </div>
    </div>
</div>

@endsection

<!-- inserted at the end of app -->
@section('javascript')

    <!-- required for all pages for proper tab and drop-down functionality -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <!-- Slick required -->
    {{--
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="{{asset('/slick/slick.min.js')}}"></script>

    --}}
    <script type="text/javascript" src="{{asset('js/user/profile.js')}}"></script>
@endsection
