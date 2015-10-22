@extends('layouts.textbook')

@section('title', 'Donate a textbook')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <div class="page-header">
                    <h1>Donate your book</h1>
                </div>

                @include('includes.textbook.pickup-address')

                <h3>Choose a pickup time</h3>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="datetimepicker-donation-pickup-time"></div>
                    </div>
                </div>

                <form action="{{ url('textbook/donate/store') }}" method="post">
                    {!! csrf_field() !!}

                    <?php $address = Auth::user()->defaultAddress(); ?>
                    <input type="hidden" name="address_id" value="{{ $address ? $address->id : '' }}">
                    <input type="hidden" name="scheduled_pickup_time">

                    <div class="form-group">
                        <label>How many books would you like to donate?</label>
                        <input type="number" name="quantity" class="form-control" min="1" value="1">
                    </div>

                    <input type="submit" class="btn btn-primary" value="Donate">
                </form>

                <br>
            </div>
        </div>
    </div>

@endsection


