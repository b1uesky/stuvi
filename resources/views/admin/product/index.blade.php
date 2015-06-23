@extends('admin')

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

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Book Title</th>
            <th>Price</th>
            <th>Seller Email</th>
            <th>Images</th>
            <th>Sold</th>
            <th>Verified</th>
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
                        <a href="{{ $image->path }}" target="_blank"><img src="{{ $image->path }}" class="admin-img-preview" alt=""/></a>
                    @endforeach
                </td>
                <td>{{ $product->isSold() }}</td>
                <td>{{ $product->isVerified() }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>

                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                    <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                    <div class="btn-group-vertical" role="group">
                        <a class="btn btn-default" role="button" href="{{ URL::to('admin/product/' . $product->id) }}">View Details</a>
                        @if(!$product->verified)
                            <a class="btn btn-success" role="button" href="{{ URL::to('admin/product/' . $product->id . '/approve') }}">Approve</a>
                        @else
                            <a class="btn btn-danger" role="button" href="{{ URL::to('admin/product/' . $product->id . '/disapprove') }}">Disapprove</a>
                        @endif
                    </div>

                </td>
            </tr>
        @endforeach

    </table>

@endsection
