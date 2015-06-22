@extends('admin')

@section('content')
    <div class="container">
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
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@endsection