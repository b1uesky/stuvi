{{-- Your orders page --}}

@extends('app')

@section('title', 'Order details - Order #'.$seller_order->id)

@section('css')
    <link href="{{ asset('/css/order_show.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/jquery.datetimepicker.css') }}">
@endsection

@section('content')
    <div class="container">
        {!! Breadcrumbs::render() !!}

        <div class="page-header">
            <h1>Order Details</h1>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <span>Sold on {{ $seller_order->created_at }}</span>
                        </div>
                        <div class="col-md-2">
                            <span>Order #{{ $seller_order->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- select address --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        {{-- Select pickup address --}}
                        <h3>Pickup Address</h3>

                        <?php $seller_order->address ? $address = $seller_order->address : $address = $seller_order->seller()->defaultAddress(); ?>
                        {{-- If the seller has a default address --}}
                        @if($address)
                            <div class="seller-address-box">
                                <div class="seller-address">
                                    <ul class="address-list">
                                        {{-- WARNING: if you need to change class names below,
                                        make sure you change the selectors in updateDefaultAddress() in `show.js`. --}}
                                        <input type="hidden" name="seller-address-address-id" value={{$address->id}}>
                                        <li class="seller-address-addressee">{{ $address->addressee }}</li>
                                        <li class="seller-address-address-line">
                                            @if($address->address_line2)
                                                {{ $address->address_line1 }}, {{ $address->address_line2 }}
                                            @else
                                                {{ $address->address_line1 }}
                                            @endif
                                        </li>
                                        <li>
                                            <span class="seller-address-city">{{ $address->city }}, </span>
                                            <span class="seller-address-state">{{ $address->state_a2 }} </span>
                                            <span class="seller-address-zip">{{ $address->zip }}</span>
                                        </li>
                                        <span class="seller-address-country">{{ $address->country_name }}</span>
                                        <br>
                                        <span class="seller-address-phone">Phone: {{ $address->phone_number }}</span>
                                        <br>
                                    </ul>
                                </div>
                                <br>

                                @if ($seller_order->isPickupConfirmable())
                                    <div>
                                        <button type="button" class="btn primary-btn btn-change-address">Change
                                        </button>
                                    </div>
                                    <br>
                                @endif

                                {{-- Invisible by default. Show after click the change button. --}}
                                <div class="seller-address-book">
                                    @foreach($seller_order->seller()->addresses as $address)
                                        <div class="col-md-3 col-sm-5 seller-address-book-box">
                                            <span class="seller-address-addressee">{{ $address->addressee }}</span>
                                            <br>
                                <span class="seller-address-address-line">
                                    @if($address->address_line2)
                                        {{ $address->address_line1 }}, {{ $address->address_line2 }}
                                    @else
                                        {{ $address->address_line1 }}
                                    @endif
                                </span>
                                            <br>
                                <span>
                                    <span class="seller-address-city">{{ $address->city }}, </span>
                                    <span class="seller-address-state">{{ $address->state_a2 }} </span>
                                    <span class="seller-address-zip">{{ $address->zip }}</span>
                                </span>
                                            <br>
                                            <span class="seller-address-country">{{ $address->country_name }}</span>
                                            <br>
                                            <span class="seller-address-phone">Phone: {{ $address->phone_number }}</span>
                                            <br>

                                            <div class="row">
                                                {{-- Ajax: select default address --}}
                                                <form action="" method="post"
                                                      class="form-update-default-address col-xs-1"
                                                      id="select-address-form">
                                                    <input type="hidden" name="address_id" value="{{ $address->id }}"/>
                                                    <input type="submit" name="submit" value="Select"
                                                           class="btn btn-default"/>
                                                </form>

                                                {{-- TODO: Edit address --}}
                                                <form action="" method="post"
                                                      class="form-edit-address col-xs-1 col-xs-offset-1 col-sm-offset-2 "
                                                      id="edit-address-form">
                                                    <input type="hidden" name="address_id" value="{{ $address->id }}"/>
                                                    <input type="submit" name="submit" value="Edit"
                                                           class="btn btn-default"/>
                                                </form>
                                            </div>

                                        </div>

                                    @endforeach

                                    {{-- Add a new address --}}
                                    <div id="add-new-address-btn-1">
                                        <button class="btn primary-btn add-address-btn">Add a new address</button>
                                        <br><br>

                                    </div>
                                </div>
                            </div>
                            {{--@elseif($order_has_address)--}}
                        @else
                            {{-- Add a new address --}}
                            <div id="add-new-address-btn-2">
                                <button class="btn primary-btn add-address-btn">Add a new address</button>
                                <br><br>
                            </div>
                        @endif
                        {{--Add or edit address modal--}}
                        <div class="modal fade" id="address-form-modal" tabindex="-1" role="dialog"
                             aria-labelledby="addressModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('/address/update') }}" method="POST"
                                              id="seller-address-form">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="address_id" value="">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label"
                                                       for="address-form-modal-addressee">Full
                                                    name</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="addressee"
                                                           id="address-form-modal-addressee"
                                                           value="">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label"
                                                       for="address-form-modal-address_line1">Address
                                                    line 1</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control"
                                                           id="address-form-modal-address_line1"
                                                           name="address_line1"
                                                           value="185 Freeman St.">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label"
                                                       for="address-form-modal-address_line2">Address
                                                    line 2</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control"
                                                           id="address-form-modal-address_line2"
                                                           name="address_line2"
                                                           value="Apt. 739">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label"
                                                       for="address-form-modal-city">City</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="city"
                                                           id="address-form-modal-city"
                                                           value="Brookline">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label"
                                                       for="address-form-modal-state_a2">State</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="state_a2"
                                                           id="address-form-modal-state_a2"
                                                           value="MA">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label"
                                                       for="address-form-modal-zip">Zip</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="zip"
                                                           id="address-form-modal-zip"
                                                           value="02446">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label"
                                                       for="address-form-modal-phone_number">Phone</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="tel" class="form-control phone_number"
                                                           id="address-form-modal-phone_number"
                                                           name="phone_number" value="(857) 206 4789">
                                                </div>
                                            </div>
                                            <input type="hidden" name="address_id" value="">
                                            <br>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" id="delete-address" class="btn btn-primary">Delete
                                        </button>
                                        <button type="button" id="submit-address-form" class="btn btn-primary">Save
                                            changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- pickup time --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        {{-- If the order is not cancelled and not picked up --}}
                        @if(!$seller_order->cancelled/* && !$seller_order->pickedUp()*/)

                            {{-- Schedule pickup time --}}
                            <h3>Pickup Time</h3>

                            <div class="text-scheduled-pickup-time">
                                @if($seller_order->scheduledPickupTime())
                                    Scheduled pickup time:
                                    <mark>{{ date(config('app.datetime_format'), strtotime($seller_order->scheduled_pickup_time)) }}</mark>
                                @else
                                    {{-- Nothing --}}
                                @endif
                            </div>

                            <br>

                            @if ($seller_order->isPickupConfirmable())
                                <form action="{{ url('/order/seller/setscheduledtime') }}" method="POST"
                                      id="schedule-pickup-time">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="schedule-token">
                                    <input type="hidden" name="seller_order_id" value="{{ $seller_order->id }}">

                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label class="sr-only" for="datetimepicker">Date and Time</label>

                                            <div class="input-group">
                                                <div class="input-group-addon" id="cal-icon"
                                                     onclick="setFocusToTextBox()"><i
                                                            class="fa fa-calendar"></i></div>
                                                <input class="form-control input-append date" id="datetimepicker"
                                                       type="text"
                                                       name="scheduled_pickup_time">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn primary-btn">
                                            <!-- scheduled already and not cancelled. allows for reschedule -->
                                            @if($seller_order->scheduledPickupTime() && !$seller_order->cancelled)
                                                Reschedule
                                            @else
                                                Schedule
                                            @endif
                                        </button>
                                    </div>

                                    <br><br>

                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- item --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    {{-- order status --}}
                    <div class="row">
                        <h3>{{ $seller_order->getOrderStatus()['status'] }}</h3>
                        <small>{{ $seller_order->getOrderStatus()['detail'] }}</small>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-9">
                            <!-- product list -->
                            <div class="row">
                                <?php $product = $seller_order->product;?>

                                {{-- book image --}}
                                <div class="col-md-2">
                                    <a href="{{ url('/textbook/buy/product/'.$product->id) }}">
                                        @if($product->book->imageSet->small_image)
                                            <img class="img-responsive img-small"
                                                 src="{{ config('aws.url.stuvi-book-img') . $product->book->imageSet->small_image}}">
                                        @else
                                            <img class="img-responsive img-small"
                                                 src="{{ config('book.default_image_path.large') }}">
                                        @endif
                                    </a>
                                </div>

                                {{-- book details --}}
                                <div class="col-md-10">
                                    <div class="row">
                                                <span>
                                                    <a href="{{ url('/textbook/buy/product/'.$product->id) }}">{{ $product->book->title }}</a>
                                                </span>
                                    </div>

                                    <div class="row">
                                        <span>ISBN-10: {{ $product->book->isbn10 }}</span>
                                    </div>

                                    <div class="row">
                                        <span>ISBN-13: {{ $product->book->isbn13 }}</span>
                                    </div>

                                    <div class="row">
                                        <span class="price">${{ $product->decimalPrice() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- action buttons --}}
                        <div class="col-md-3">
                            {{-- Confirm pickup --}}
                            @if ($seller_order->isPickupConfirmable())
                                <a href="{{ url('/order/seller/' . $seller_order->id . '/confirmPickup') }}" class="btn primary-btn btn-block">Confirm Pickup</a>
                            @endif

                            {{-- cancel order --}}
                            @if ($seller_order->isCancellable())
                                <a class="btn btn-default btn-block" href="/order/seller/cancel/{{ $seller_order->id }}"
                                   role="'button">Cancel Order</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('libs/datetimepicker/jquery.datetimepicker.js') }}"></script>
    <script src="{{ asset('js/order/seller/show.js') }}"></script>
@endsection