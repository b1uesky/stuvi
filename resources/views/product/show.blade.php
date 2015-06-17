@extends('product')

@section('content')
<div class="container">
    <div class="row">
        <h2>{{ $book->title }}</h2>

        @if(!empty($images))
            @foreach($images as $image)
                <div class="">
                    <img src="{{ $image->path }}" alt="" />
                </div>
            @endforeach
        @endif

        <div class="">
            Price: {{ $product->price }}
        </div>

        <a href="{{ url('/cart/add/'.$product->id) }}">Add to Cart</a>

        <table style="width:100%" border="1">
            <tr>
                <th>Condition</th>
                <th>Rating</th>
            </tr>
            <tr>
                <td>{{ $conditions['highlights'] }}</td>
                <td>{{ $condition->highlights }}</td>
            </tr>
            <tr>
                <td>{{ $conditions['notes'] }}</td>
                <td>{{ $condition->notes }}</td>
            </tr>
            <tr>
                <td>{{ $conditions['num_damaged_pages'] }}</td>
                <td>{{ $condition->num_damaged_pages }}</td>
            </tr>
            <tr>
                <td>{{ $conditions['broken_spine'] }}</td>
                <td>{{ $condition->broken_spine }}</td>
            </tr>
            <tr>
                <td>{{ $conditions['broken_binding'] }}</td>
                <td>{{ $condition->broken_binding }}</td>
            </tr>
            <tr>
                <td>{{ $conditions['water_damage'] }}</td>
                <td>{{ $condition->water_damage }}</td>
            </tr>
            <tr>
                <td>{{ $conditions['stains'] }}</td>
                <td>{{ $condition->stains }}</td>
            </tr>
            <tr>
                <td>{{ $conditions['burns'] }}</td>
                <td>{{ $condition->burns }}</td>
            </tr>
            <tr>
                <td>{{ $conditions['rips'] }}</td>
                <td>{{ $condition->rips }}</td>
            </tr>
        </table>

        @if($condition->description != '')
            <h4>Seller's description on the book conditions:</h4>
            <div class="">
                {{ $condition->description }}
            </div>
        @endif

    </div>

</div>
@endsection
