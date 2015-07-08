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

        {{-- Product Images --}}
        @foreach($product->images as $index => $image)
            <tr>
                <th>Image #{{ $index + 1 }}</th>
                <td><a href="{{ $image->path }}" target="_blank"><img src="{{ $image->path }}" alt="" /></a></td>
            </tr>
        @endforeach
    </table>

    {{-- Approve/Disapprove --}}
    @if(!$product->verified)
        <a class="btn btn-success" href="{{ URL::to('admin/product/' . $product->id . '/approve') }}">Approve</a>
    @else
        <a class="btn btn-danger" href="{{ URL::to('admin/product/' . $product->id . '/disapprove') }}">Disapprove</a>
    @endif

@endsection
