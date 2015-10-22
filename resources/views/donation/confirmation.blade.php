@extends('layouts.textbook')

@section('title', 'Donation confirmation)

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <h2>Thanks for donating your book!</h2>

                <hr>

                <p>We will send you an email at <code>{{ Auth::user()->primaryEmail->email_address }}</code> once our courier is ready to pick up your books.</p>
                <p>Please feel free to <a href="{{ url('/contact') }}">contact us</a> with any questions or concerns.</p>

                {{--<br>--}}

                {{--<a class="btn btn-primary" href="{{ url('donation/'.$donation->id) }}">View donation details</a>--}}
            </div>



        </div>

    </div>
@endsection