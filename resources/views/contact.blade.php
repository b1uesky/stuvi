@extends('layouts.textbook')

@section('title', 'Contact us')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="page-header">
                    <h1>Contact us</h1>
                </div>

                <div class="margin-bottom-15">
                    <small class="text-muted">Please feel free to ask a question or give us feedback.</small>
                </div>

                <form action="/contact/store" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        @if(Auth::check())
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->fullName() }}"
                                   placeholder="Name">
                        @else
                            <input type="text" class="form-control" name="name" placeholder="Name">
                        @endif
                    </div>

                    <div class="form-group">
                        @if(Auth::check())
                            <input type="email" class="form-control" name="email"
                                   value="{{ Auth::user()->primaryEmail->email_address }}" placeholder="Email">
                        @else
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        @endif
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" rows="8" name="message" placeholder="Message"></textarea>
                    </div>

                    <button type="submit" class="btn btn-block btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <br>
    </div>

@endsection