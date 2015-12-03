@extends('layouts.express')

@section('title', 'Pickup')

@section('content')


        {{-- New/Picked Up switch buttons --}}
        <div class="btn-group btn-group-justified" role="group">
            <a href="{{ url('express/pickup') }}" role="button" class="btn btn-default">New</a>
            <a href="{{ url('express/pickup/todo') }}" role="button" class="btn btn-default">Todo</a>
            <a href="{{ url('express/pickup/pickedUp') }}" role="button" class="btn btn-default">Picked Up</a>
        </div>

        <br>

        {{-- Seller Order Details --}}
        <div class="list-group">
            {{-- Order Number --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Order Number</h4>
                <p class="list-group-item-text">{{ $seller_order->id }}</p>
            </li>

            {{-- Book Info --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">{{ $seller_order->book()->title }}</h4>
                <div class="media">
                    <img class="img-responsive" src="{{ $seller_order->book()->imageSet->getImagePath('medium') }}" alt=""/>
                </div>
            </li>

            {{-- Scheduled Pickup Time --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Scheduled Pickup Time</h4>
                <p class="list-group-item-text">{{ $seller_order->scheduled_pickup_time }}</p>
            </li>

            {{-- Address --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Address</h4>
                <p class="list-group-item-text">
                    {{ $seller_order->address->addressee }}
                </p>
                <p class="list-group-item-text">
                    {{ $seller_order->address->address_line1 }},
                    {{ $seller_order->address->address_line2 }}
                </p>
                <p class="list-group-item-text">
                    {{ $seller_order->address->city }},
                    {{ $seller_order->address->state_a2 }}
                    {{ $seller_order->address->zip }}
                </p>
            </li>

            {{-- Phone Number --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Phone Number</h4>
                <p class="list-group-item-text">
                    {{ $seller_order->address->phone_number }}
                </p>
            </li>

            {{-- Sale price --}}
            {{--<li class="list-group-item">--}}
                {{--<h4 class="list-group-item-heading">Price</h4>--}}
                {{--<p class="list-group-item-text price">--}}
                    {{--${{ $seller_order->product->price }}--}}
                {{--</p>--}}
            {{--</li>--}}

            @if($seller_order->product->payout_method == 'cash')
                <li class="list-group-item">
                    <h4 class="list-group-item-heading">
                        Please pay seller <span class="price">
                            @if($seller_order->buyer_order_id)
                                ${{ $seller_order->product->price }}
                            @else
                                ${{ $seller_order->product->trade_in_price }}
                            @endif
                        </span> in cash.
                    </h4>

                    @if(config('sale.payout_service') > 0)
                        <p class="list-group-item-text">
                            Sale price: ${{ $seller_order->product->price }}
                        </p>

                        <p class="list-group-item-text">
                            Payout service fee: -${{ config('sale.payout_service') }}
                        </p>
                    @endif

                </li>
            @endif

        </div>

        {{-- Ready to pick up --}}
        @if(!$seller_order->isAssignedToCourier())
            <a href="{{ url('express/pickup/'. $seller_order->id . '/readyToPickUp') }}" class="btn btn-primary btn-lg btn-block">
                Ready to pick up
            </a>
        {{-- Verification Code --}}
        @elseif(!$seller_order->pickedUp())
            <form action="{{ url('express/pickup/' . $seller_order->id . '/confirm') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    By confirming the pickup, you agree to Stuvi's <a href="{{url('/tos')}}" target="_blank" > Terms of Service</a>
                        and <a href="{{url('/privacy')}}" target="_blank"> Privacy Notice</a>.
                </div>

                <div class="form-group">
                    <input type="number" class="form-control input-lg" name="code" placeholder="Enter the 4-digit verification code" required/>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">Confirm pickup</button>
            </form>
        @else
            <div class="alert alert-success" role="alert">The textbook has been picked up.</div>
        @endif

        <br>

@endsection
