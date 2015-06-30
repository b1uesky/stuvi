@extends('app')

@section('content')
    <div class="container">

        {{-- Errors --}}
        @if ($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <div class="row">
            <form action="/order/seller/storeAddress" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="seller_order_id" value="{{ $seller_order->id }}"/>

                <div class="form-group">
                    <label>Full name</label>
                    <input type="string" name="addressee" value="{{ Input::old('addressee') }}" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Address line 1</label>
                    <input type="string" name="address_line1" value="{{ Input::old('address_line1') }}"
                           class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Address line 2</label>
                    <input type="string" name="address_line2" value="{{ Input::old('address_line2') }}"
                           class="form-control"/>
                </div>

                <div class="form-group">
                    <label>City</label>
                    <input type="string" name="city" value="{{ Input::old('city') }}" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>State</label>
                    <input type="string" name="state_a2" value="{{ Input::old('state_a2') }}" class="form-control"/>
                </div>

                <div class="form-group">
                    <label>Zip</label>
                    <input type="string" name="zip" value="{{ Input::old('zip') }}" class="form-control"/>
                </div>

                @if(Config::get('addresses.show_country'))
                    <div class="form-group">
                        <label>Country</label>
                        <input type="string" name="country" value="{{ Input::old('country') }}" class="form-control"/>
                    </div>
                @endif

                <div class="form-group">
                    <label>Phone number</label>
                    <input type="string" name="phone_number" value="{{ Input::old('phone_number') }}"
                           class="form-control"/>
                </div>

                <input type="submit" name="submit" class="btn btn-primary" value="Add this address"/>

            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection