@extends('layouts.admin')

@section('title', 'Product')

@section('content')

    <table class="table table-condensed">
        <caption>Details</caption>

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
            <td class="price">
                @if($product->price)
                    ${{ $product->decimalPrice() }}
                @else
                    N/A
                @endif
            </td>
        </tr>
        <tr>
            <th>Seller</th>
            <td><a href="{{ url('admin/user/'.$product->seller_id) }}">{{ $product->seller->first_name }} {{ $product->seller->last_name }}</a></td>
        </tr>
        <tr>
            <th>Sell to</th>
            <td>{{ $product->sell_to }}</td>
        </tr>
        <tr>
            <th>Available at</th>
            <td>{{ $product->available_at }}</td>
        </tr>
        <tr>
            <th>Payout method</th>
            <td>{{ $product->payout_method }}</td>
        </tr>
        <tr>
            <th>Verified</th>
            <td>{{ $product->isVerified() }}</td>
        </tr>
        <tr>
            <th>Rejected</th>
            <td>{{ $product->isRejected() }}</td>
        </tr>
        <tr>
            <th>Sold</th>
            <td>{{ $product->isSoldToStr() }}</td>
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
            <td class="container-flex">
                @foreach($product->images as $image)
                    <div>
                        <img class="img-rounded img-small margin-5 full-width"
                             src="{{ $image->getImagePath('large') }}"
                             data-action="zoom">
                    </div>
                @endforeach
            </td>
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
            <th>Deleted At</th>
            <td>{{ $product->deleted_at }}</td>
        </tr>
    </table>


    <table class="table table-condensed" data-sortable>
        <caption>Seller orders</caption>

        <thead>
            <tr class="active">
                <th>ID</th>
                <th>BuyerOrder ID</th>
                <th>Cancelled</th>
                <th>Scheduled Pickup Time</th>
                <th>Pickup Time</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($seller_orders as $seller_order)
                <tr>
                    <td>{{ $seller_order->id }}</td>
                    <td><a href="{{ url('admin/order/buyer/'.$seller_order->buyer_order_id) }}">{{ $seller_order->buyer_order_id }}</a></td>
                    <td>{{ $seller_order->cancelled }}</td>
                    <td>{{ $seller_order->scheduled_pickup_time }}</td>
                    <td>{{ $seller_order->pickup_time }}</td>
                    <td>{{ $seller_order->created_at }}</td>
                    <td><a class="btn btn-info" role="button" href="{{ url('admin/order/seller/' . $seller_order->id) }}">Details</a></td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <hr>

    @if($product->sell_to == 'user')
        @if(!$product->verified)
            <a class="btn btn-success" href="{{ url('admin/product/' . $product->id . '/approve') }}">Approve</a>
        @else
            <a class="btn btn-danger" href="{{ url('admin/product/' . $product->id . '/disapprove') }}">Disapprove</a>
        @endif
    @else
        @if(!$product->verified)
            <form action="{{ url('admin/product/' . $product->id . '/updatePriceAndApprove') }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                    <input type="number" step="0.01" class="form-control" name="price" placeholder="Product price">
                </div>

                <input type="submit" class="btn btn-success" value="Update price and approve">
            </form>
        @else
            <a class="btn btn-danger" href="{{ url('admin/product/' . $product->id . '/disapprove') }}">Disapprove</a>
        @endif

        <hr>

        @if(!$product->is_rejected)
            <form action="{{ url('admin/product/' . $product->id . '/reject') }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                    <textarea class="form-control" name="rejected_reason" placeholder="Reason for rejection"></textarea>
                </div>

                <input type="submit" class="btn btn-danger" value="Reject">
            </form>
        @else
            <form action="{{ url('admin/product/' . $product->id . '/accept') }}" method="post">
                {!! csrf_field() !!}

                <input type="submit" class="btn btn-success" value="Accept">
            </form>
        @endif
    @endif

@endsection
