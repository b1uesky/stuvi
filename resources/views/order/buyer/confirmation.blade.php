@extends('layouts.textbook')

@section('title', 'Order confirmation #'.Session::get('order')->id )

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <div class="row margin-30">
            <nav>
                <ol class="cd-multi-steps text-top">
                    <li class="visited">
                        <span>Cart</span>
                    </li>
                    <li class="visited">
                        <span>Checkout</span>
                    </li>
                    <li class="current">
                        <span>Done</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <h2>Thanks for using Stuvi!</h2>

                <hr>

                <p>You will receive an email confirmation shortly at <code>{{ Auth::user()->primaryEmail->email_address }}</code>.</p>
                <p>Once our courier is ready, you will be notified the delivery time of your books.</p>
                <p>Please feel free to <a href="{{ url('/contact') }}">contact us</a> with any questions or concerns.</p>

                <br>

                <a class="btn btn-primary" href="{{ url('order/buyer/'.Session::get('order')->id) }}">View order details</a>
            </div>



        </div>

    </div>
@endsection