@extends('app')

@section('title', 'Contact us')

@section('css')
    <link href="{{ asset('/css/contact.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="contact-container">
        <div class="row">
            <div class="col-sm-offset-2">
                <h2 class="contact-title">Contact Us</h2>

                <div class="contact-subtitle">
                    <p>Please feel free to ask a question or give us feedback.</p>
                </div>
            </div>

            <form action="" class="form-horizontal">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control input-lg" name="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control input-lg" name="name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Message</label>

                    <div class="col-sm-10">
                        <textarea class="form-control input-lg" rows="8" name="message"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-lg btn-block primary-btn">Submit</button>
                    </div>
                </div>
            </form>

            <hr>

            <div class="col-sm-offset-2 contact-email">
                <p>You're welcome to email us at <a href="mailto:official@stuvi.com">official@stuvi.com</a></p>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection