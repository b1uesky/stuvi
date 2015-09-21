@extends('layouts.admin')

@section('title', 'Book')

@section('content')

    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $book->id }}</td>
        </tr>
        <tr>
            <th>Cover</th>
            <td>
                <img class="img-responsive" src="{{ $book->imageSet->getImagePath('small') }}">
            </td>
        </tr>
        <tr>
            <th>Title</th>
            <td>{{ $book->title }}</td>
        </tr>
        <tr>
            <th>Edition</th>
            <td>{{ $book->edition }}</td>
        </tr>
        <tr>
            <th>ISBN10</th>
            <td>{{ $book->isbn10 }}</td>
        </tr>
        <tr>
            <th>ISBN13</th>
            <td>{{ $book->isbn13 }}</td>
        </tr>
        <tr>
            <th>Number of Pages</th>
            <td>{{ $book->num_pages }}</td>
        </tr>
        <tr>
            <th>Verified</th>
            <td>{{ $book->is_verified }}</td>
        </tr>
        <tr>
            <th>Language</th>
            <td>{{ $book->language }}</td>
        </tr>
        {{--<tr>--}}
            {{--<th>List Price</th>--}}
            {{--<td>$ {{ $book->list_price }}</td>--}}
        {{--</tr>--}}
        <tr>
            <th>Highest Price</th>
            <td>$ {{ \App\Helpers\Price::convertIntegerToDecimal($book->highest_price) }}</td>
        </tr>
        <tr>
            <th>Lowest Price</th>
            <td>$ {{ \App\Helpers\Price::convertIntegerToDecimal($book->lowest_price) }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $book->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $book->updated_at }}</td>
        </tr>
    </table>

    <p><strong>Products</strong></p>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
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
                <td>{{ $product->decimalPrice() }}</td>
                <td><a href="{{ url('/admin/user/'.$product->seller->id) }}">{{ $product->seller->first_name }} {{ $product->seller->last_name }}</a></td>
                <td>
                    @foreach($product->images as $product_image)
                        <a href="{{ $product_image->large_image }}" target="_blank">
                            <img src="{{ $product_image->getImagePath('small') }}"/>
                        </a>
                    @endforeach
                </td>
                <td>{{ $product->isSoldToStr() }}</td>
                <td>{{ $product->isVerified() }}</td>
                <td>{{ $product->updated_at }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>

                    <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                    <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                    <div class="btn-group-vertical" role="group">
                        <a class="btn btn-default" role="button" href="{{ URL::to('admin/product/' . $product->id) }}">Details</a>
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

@endsection
