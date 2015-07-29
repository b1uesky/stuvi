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
                        @if (Session::has('email_set_primary_success'))
                            <div class="alert alert-success" id="message">{{ Session::get('email_set_primary_success') }}</div>
                        @elseif (Session::has('email_remove_success'))
                            <div class="alert alert-success" id="message">{{ Session::get('email_remove_success') }}</div>
                        @elseif (Session::has('email_add_success'))
                            <div class="alert alert-success" id="message">{{ Session::get('email_add_success') }}</div>
                        @elseif (Session::has('email_verify_success'))
                            <div class="alert alert-success" id="message">{{ Session::get('email_verify_success') }}</div>
                        @elseif (Session::has('email_remove_error'))
                            <div class="alert alert-danger" id="message">{{ Session::get('email_remove_error') }}</div>
                        @elseif (Session::has('email_set_primary_error'))
                            <div class="alert alert-danger" id="message">{{ Session::get('email_set_primary_error') }}</div>
                        @elseif (Session::has('email_verify_error'))
                            <div class="alert alert-danger" id="message">{{ Session::get('email_verify_error') }}</div>
                        @endif
                        <h3>Email</h3>
                        {{-- Email List --}}
                        <p>Note: Stuvi will send all notification email to your primary email.</p>
                        <table class="table table-hover">
                            @foreach ($emails as $email)
                                <tr>
                                    <td><strong>{{ $email->email_address }}</strong></td>
                                    @if ($email->isPrimary())
                                        <td>
                                            Primary
                                        </td>
                                        <td></td>
                                    @else
                                        @if (!$email->verified)
                                            <td>
                                                Unverified
                                            </td>
                                        @else
                                            <td>
                                            <form action="{{ url('/user/email/primary') }}" method="post">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="id" value="{{ $email->id }}">
                                                <input type="submit" class="btn primary-btn" value="Set as primary">
                                            </form>
                                        </td>
                                        @endif
                                        <td>
                                            @if (!$email->isCollegeEmail())
                                                <form action="{{ url('/user/email/remove') }}" method="post">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="id" value="{{ $email->id }}">
                                                    <input type="submit" class="btn primary-btn" value="Remove">
                                                </form>
                                            @endif
                                        </td>
                                    @endif
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
                                @foreach (Session::get('email_validation_error')->get('email') as $err)
                                    <div class="alert alert-warning" id="message">{{ $err }}</div>
                                @endforeach
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

    <!-- Slick required -->
    {{--
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="{{asset('/slick/slick.min.js')}}"></script>

    --}}
    <script type="text/javascript" src="{{asset('js/user/email.js')}}"></script>
@endsection
