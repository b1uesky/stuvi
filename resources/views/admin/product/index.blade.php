@extends('admin')

@section('title', 'Product')

@section('content')

    {{--<div class="btn-group" role="group">--}}
        {{--<a href="{{ URL::to('admin/product') }}" class="btn btn-default">All</a>--}}
        {{--<a href="{{ URL::to('admin/product/unverified') }}" class="btn btn-default">Unverified Only</a>--}}
        {{--<a href="{{ URL::to('admin/product/verified') }}" class="btn btn-default">Verified Only</a>--}}
    {{--</div>--}}

    <h1>Products</h1>

    <form class="form-inline" role="form" action="{{ url('admin/product') }}" method="get">
        <div class="form-group">
            <select name="filter" class="form-control">
                <option value="id" @if ($pagination_params['filter'] == 'id') selected @endif>ID</option>
                <option value="title" @if ($pagination_params['filter'] == 'title') selected @endif>Title</option>
                <option value="seller" @if ($pagination_params['filter'] == 'seller') selected @endif>Seller</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <input type="text" class="form-control input-large" name="keyword" value="{{ $pagination_params['keyword'] }}">
        </div><!-- form group [search] -->
        <div class="form-group">
            <label class="filter-col" style="margin-right:0;">Order by:</label>
            <select name="order_by" class="form-control">
                <option value="id" @if ($pagination_params['order_by'] == 'id') selected @endif>ID</option>
                <option value="title" @if ($pagination_params['order_by'] == 'title') selected @endif>Title</option>
                <option value="first_name" @if ($pagination_params['order_by'] == 'first_name') selected @endif>Seller First Name</option>
                <option value="last_name" @if ($pagination_params['order_by'] == 'last_name') selected @endif>Seller Last Name</option>
                <option value="price" @if ($pagination_params['order_by'] == 'price') selected @endif>Price</option>
                <option value="sold" @if ($pagination_params['order_by'] == 'sold') selected @endif>Sold</option>
                <option value="activated" @if ($pagination_params['order_by'] == 'activated') selected @endif>Activated</option>
                <option value="created_at" @if ($pagination_params['order_by'] == 'created_at') selected @endif>Created At</option>
                <option value="updated_at" @if ($pagination_params['order_by'] == 'updated_at') selected @endif>Updated At</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <select name="order" class="form-control">
                <option value="DESC" @if ($pagination_params['order'] == 'DESC') selected @endif>DESC</option>
                <option value="ASC" @if ($pagination_params['order'] == 'ASC') selected @endif>ASC</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <button type="submit" class="btn btn-default filter-col">
                Search
            </button>
        </div>
    </form>


    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Book Title</th>
            <th>Price</th>
            <th>Seller</th>
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
                <td>$ {{ $product->decimalPrice() }}</td>
                <td><a href="{{ url('/admin/user/'.$product->seller->id) }}">{{ $product->seller->first_name }} {{ $product->seller->last_name }}</a></td>
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
                <td>{{ $product->isSold2() }}</td>
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

    {!! $products->appends($pagination_params)->render() !!}
@endsection
