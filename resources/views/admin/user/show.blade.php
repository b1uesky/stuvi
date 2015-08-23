@extends('layouts.admin')

@section('title', 'User')

@section('content')

    <h1>User Detail</h1>

    <p><strong>Overview</strong></p>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>First Name</th>
            <td>{{ $user->first_name }}</td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>{{ $user->last_name }}</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td>{{ $user->phone_number }}</td>
        </tr>
        <tr>
            <th>Activated</th>
            <td>{{ $user->isActivated2() }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ $user->role }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $user->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $user->updated_at }}</td>
        </tr>
    </table>

    <p><strong>Emails</strong></p>
    <table class="table table-hover">
        <tr>
            <th>Address</th>
            <th>Verified</th>
            <th>Primary</th>
        </tr>
        @foreach($emails as $email)
            <tr>
                <td>{{ $email->email_address }}</td>
                <td>{{ $email->verified }}</td>
                <td>{{ $email->isPrimary() }}</td>
            </tr>
        @endforeach
    </table>

    <p><strong>Bookshelf</strong></p>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Book Title</th>
            <th>Price</th>
            <th>Images</th>
            <th>Sold</th>
            <th>Verified</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>

        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><a href="{{ url('admin/book/'.$product->book->id) }}">{{ $product->book->title }}</a></td>
                <td>{{ $product->decimalPrice() }}</td>
                <td>
                    @foreach($product->images as $product_image)
                        @if($product_image->isTestImage())
                            <a href="{{ $product_image->large_image }}" target="_blank">
                                <img src="{{ $product_image->small_image }}" class="admin-img-preview" alt=""/>
                            </a>
                        @else
                            <a href="{{ Config::get('aws.url.stuvi-product-img') . $product_image->large_image }}" target="_blank">
                                <img src="{{ Config::get('aws.url.stuvi-product-img') . $product_image->small_image }}" class="admin-img-preview" alt=""/>
                            </a>
                        @endif
                    @endforeach
                </td>
                <td>{{ $product->isSold() }}</td>
                <td>{{ $product->isVerified() }}</td>
                <td>{{ $product->updated_at }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>

                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                    <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                    <div class="btn-group-vertical" role="group">
                        <a class="btn btn-info" role="button" href="{{ URL::to('admin/product/' . $product->id) }}">Details</a>
                        @if(!$product->verified)
                            <a class="btn btn-success" role="button"
                               href="{{ URL::to('admin/product/' . $product->id . '/approve') }}">Approve</a>
                        @else
                            <a class="btn btn-danger" role="button"
                               href="{{ URL::to('admin/product/' . $product->id . '/disapprove') }}">Disapprove</a>
                        @endif
                    </div>

                </td>
            </tr>
        @endforeach
    </table>

    <p><strong>Buyer Orders</strong></p>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Cancelled</th>
            <th>Delivered Time</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        @forelse($buyer_orders as $buyer_order)
            <tr>
                <td>{{ $buyer_order->id }}</td>
                <td>{{ $buyer_order->cancelled }}</td>
                <td>{{ $buyer_order->time_delivered }}</td>
                <td>{{ $buyer_order->created_at }}</td>
                <td><a class="btn btn-info" role="button" href="{{ URL::to('admin/order/buyer/' . $buyer_order->id) }}">Details</a></td>
            </tr>
        @empty
            <p>This user has no buyer order.</p>
        @endforelse
    </table>

    <p><strong>Seller Orders</strong></p>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Product ID</th>
            <th>BuyerOrder ID</th>
            <th>Cancelled</th>
            <th>Scheduled Pickup Time</th>
            <th>Pickup Time</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        @foreach($seller_orders as $seller_order)
            <tr>
                <td>{{ $seller_order->id }}</td>
                <td>{{ $seller_order->product_id }}</td>
                <td>{{ $seller_order->buyer_order_id }}</td>
                <td>{{ $seller_order->cancelled }}</td>
                <td>{{ $seller_order->scheduled_pickup_time }}</td>
                <td>{{ $seller_order->pickup_time }}</td>
                <td>{{ $seller_order->created_at }}</td>
                <td><a class="btn btn-info" role="button" href="{{ URL::to('admin/order/seller/' . $seller_order->id) }}">Details</a></td>
            </tr>
        @endforeach
    </table>

@endsection
