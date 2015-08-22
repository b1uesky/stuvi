@extends('app')

@section('title', 'Contact us')

@section('css')
    <link href="{{ asset('/css/contact.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div id="contact-main-container">

        <div class="container-fluid contact-container">
            <div class="row">
                <h2 class="contact-title">Contact Us</h2>

                <div class="contact-subtitle">
                    <p>Please feel free to ask a question or give us feedback.</p>
                </div>

                <form action="/contact/store" method="post" class="form-horizontal">
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

                    <button type="submit" class="btn btn-lg btn-block primary-btn">Submit</button>
                </form>

                <hr>

                <div class="contact-email">
                    <p>
                        You're also welcome to email us at <a href="mailto:official@stuvi.com">official@stuvi.com</a>
                    </p>
                </div>
            </div>
        </div>



     </div>


@endsection

@section('javascript')
@endsection