@extends('admin')

@section('content')
    <div class="container">

        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ URL::to('admin/product') }}">Product</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="{{ URL::to('admin/product') }}">View All Products</a></li>
            </ul>
        </nav>

        <div class="row">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <td>{{ $product->id }}</td>
                </tr>
                <tr>
                    <th>Book Title</th>
                    <td>{{ $product->book->title }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{ $product->price }}</td>
                </tr>
                <tr>
                    <th>Book ID</th>
                    <td>{{ $product->book_id }}</td>
                </tr>
                <tr>
                    <th>Seller ID</th>
                    <td>{{ $product->seller_id }}</td>
                </tr>
                <tr>
                    <th>General Condition</th>
                    <td>{{ $product->condition->general_condition }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection