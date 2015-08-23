@extends('layouts.admin')

@section('title', 'Product')

@section('content')

    <h1>Product Detail
    {{-- Approve/Disapprove --}}
    @if(!$product->verified)
        <a class="btn btn-success" href="{{ URL::to('admin/product/' . $product->id . '/approve') }}">Approve</a>
    @else
        <a class="btn btn-danger" href="{{ URL::to('admin/product/' . $product->id . '/disapprove') }}">Disapprove</a>
    @endif
    </h1>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $product->id }}</td>
        </tr>
        <tr>
            <th>Book Title</th>
            <td><a href="{{ url('admin/book/'.$product->book_id) }}">{{ $product->book->title }}</a></td>
        </tr>
        <tr>
            <th>Price</th>
            <td>{{ $product->decimalPrice() }}</td>
        </tr>
        <tr>
            <th>Seller</th>
            <td><a href="{{ url('admin/user/'.$product->seller_id) }}">{{ $product->seller->first_name }} {{ $product->seller->last_name }}</a></td>
        </tr>
        <tr>
            <th>Sold</th>
            <td>{{ $product->isSold2() }}</td>
        </tr>
        <tr>
            <th>Verified</th>
            <td>{{ $product->isVerified() }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $product->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $product->updated_at }}</td>
        </tr>
        <tr>
            <th>{{ $conditions['general_condition']['title'] }}</th>
            <td>{{ $conditions['general_condition'][$product->condition->general_condition] }}</td>
        </tr>
        <tr>
            <th>{{ $conditions['highlights_and_notes']['title'] }}</th>
            <td>{{ $conditions['highlights_and_notes'][$product->condition->highlights_and_notes] }}</td>
        </tr>
        <tr>
            <th>{{ $conditions['damaged_pages']['title'] }}</th>
            <td>{{ $conditions['damaged_pages'][$product->condition->damaged_pages] }}</td>
        </tr>
        <tr>
            <th>{{ $conditions['broken_binding']['title'] }}</th>
            <td>{{ $conditions['broken_binding'][$product->condition->broken_binding] }}</td>
        </tr>
        <tr>
            <th>{{ $conditions['description']['title'] }}</th>
            <td>{{ $product->condition->description }}</td>
        </tr>
        <tr>
            <th>Images</th>
            <td>
                @forelse($product->images as $product_image)
                    @if($product_image->isTestImage())
                        <a href="{{ $product_image->large_image }}" target="_blank">
                            <img src="{{ $product_image->small_image }}" class="admin-img-preview" alt=""/>
                        </a>
                    @else
                        <a href="{{ Config::get('aws.url.stuvi-product-img') . $product_image->large_image }}" target="_blank">
                            <img src="{{ Config::get('aws.url.stuvi-product-img') . $product_image->small_image }}" class="admin-img-preview" alt=""/>
                        </a>
                    @endif
                @empty
                    No images.
                @endforelse
            </td>
        </tr>
    </table>

    <p><strong>Seller Orders</strong></p>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
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
                <td><a href="{{ url('admin/order/buyer/'.$seller_order->buyer_order_id) }}">{{ $seller_order->buyer_order_id }}</a></td>
                <td>{{ $seller_order->cancelled }}</td>
                <td>{{ $seller_order->scheduled_pickup_time }}</td>
                <td>{{ $seller_order->pickup_time }}</td>
                <td>{{ $seller_order->created_at }}</td>
                <td><a class="btn btn-info" role="button" href="{{ URL::to('admin/order/seller/' . $seller_order->id) }}">Details</a></td>
            </tr>
        @endforeach
    </table>

@endsection
