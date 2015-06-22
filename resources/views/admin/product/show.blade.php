@extends('admin')

@section('content')
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('admin/product') }}">Product</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('admin/product') }}">View All Products</a></li>
        </ul>
    </nav>

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
            @foreach($product->images as $image)
                <tr>
                    <th>Image</th>
                    <td><img src="{{ $image->path }}" alt="" /></td>
                </tr>
            @endforeach
        </table>
@endsection
