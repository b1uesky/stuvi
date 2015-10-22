@extends('layouts.textbook')

@section('title', 'Donation confirmation')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <h2>Thanks for donating your books!</h2>

                <hr>

                <p>We will send you an email at <code>{{ $donation->donator->primaryEmail->email_address }}</code> once our courier is ready to pick up your books.</p>
                <p>Please feel free to <a href="{{ url('/contact') }}">contact us</a> with any questions or concerns.</p>
            </div>
        </div>

    </div>
@endsection