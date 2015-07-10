@extends('admin')

@section('title', 'Product')

@section('content')

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="btn-group" role="group">
        <a href="{{ URL::to('admin/product') }}" class="btn btn-default">All</a>
        <a href="{{ URL::to('admin/product/unverified') }}" class="btn btn-default">Unverified Only</a>
        <a href="{{ URL::to('admin/product/verified') }}" class="btn btn-default">Verified Only</a>
    </div>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Book Title</th>
            <th>Price</th>
            <th>Seller Email</th>
            <th>Images</th>
            <th>Sold</th>
            <th>Verified</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>

        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->book->title }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->seller->email }}</td>
                <td>
                    @foreach($product->images as $image)
                        <a href="{{ $image->path }}" target="_blank"><img src="{{ $image->path }}"
                                                                          class="admin-img-preview" alt=""/></a>
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

    {!! $products->render() !!}
@endsection
