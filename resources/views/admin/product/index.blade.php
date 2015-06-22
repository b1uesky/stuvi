@extends('admin')

@section('content')
    <div class="container">

        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ URL::to('admin/product') }}">Product</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="{{ URL::to('admin/product') }}">View All Products</a></li>
                {{--<li><a href="{{ URL::to('product/create') }}">Create a Product</a>--}}
            </ul>
        </nav>

        <div class="row">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Book Title</th>
                    <th>Price</th>
                    <th>Seller Email</th>
                    <th>Images</th>
                    <th>Sold</th>
                    <th>Verified</th>
                    <th>Detail</th>
                </tr>

                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->book->title }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->seller->email }}</td>
                        <td>
                            @foreach($product->images as $image)
                                <a href="{{ $image->path }}" target="_blank"><img src="{{ $image->path }}" alt=""/></a>
                            @endforeach
                        </td>
                        <td>{{ $product->isSold() }}</td>
                        <td>{{ $product->verified }}</td>

                        <!-- we will also add show, edit, and delete buttons -->
                        <td>

                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->

                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-small btn-success" href="{{ URL::to('admin/product/' . $product->id) }}">Details</a>
                        </td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@endsection