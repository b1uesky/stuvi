@extends('product')

@section('content')
<div class="container">
    <div class="row">
        <h2>{{ $book->title }}</h2>

        @if(!empty($images))
            @foreach($images as $image)
                <div class="">
                    <img src="{{ $image->image }}" alt="" />
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
                <td>{{ $product_conditions['highlights'] }}</td>
                <td>{{ $condition->highlights }}</td>
            </tr>
            <tr>
                <td>{{ $product_conditions['notes'] }}</td>
                <td>{{ $condition->notes }}</td>
            </tr>
            <tr>
                <td>{{ $product_conditions['num_damaged_pages'] }}</td>
                <td>{{ $condition->num_damaged_pages }}</td>
            </tr>
            <tr>
                <td>{{ $product_conditions['broken_spine'] }}</td>
                <td>{{ $condition->broken_spine }}</td>
            </tr>
            <tr>
                <td>{{ $product_conditions['broken_binding'] }}</td>
                <td>{{ $condition->broken_binding }}</td>
            </tr>
            <tr>
                <td>{{ $product_conditions['water_damage'] }}</td>
                <td>{{ $condition->water_damage }}</td>
            </tr>
            <tr>
                <td>{{ $product_conditions['stains'] }}</td>
                <td>{{ $condition->stains }}</td>
            </tr>
            <tr>
                <td>{{ $product_conditions['burns'] }}</td>
                <td>{{ $condition->burns }}</td>
            </tr>
            <tr>
                <td>{{ $product_conditions['rips'] }}</td>
                <td>{{ $condition->rips }}</td>
            </tr>
        </table>

    </div>

</div>
@endsection
