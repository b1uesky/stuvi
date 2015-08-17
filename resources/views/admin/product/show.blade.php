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

    <h1>Product Detail</h1>

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

    {{-- Approve/Disapprove --}}
    @if(!$product->verified)
        <a class="btn btn-success" href="{{ URL::to('admin/product/' . $product->id . '/approve') }}">Approve</a>
    @else
        <a class="btn btn-danger" href="{{ URL::to('admin/product/' . $product->id . '/disapprove') }}">Disapprove</a>
    @endif

@endsection
