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
            Sell by: {{ $seller->email }}
        </div>

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
                <td>Highlights</td>
                <td>{{ $condition->highlights }}</td>
            </tr>
            <tr>
                <td>Notes</td>
                <td>{{ $condition->notes }}</td>
            </tr>
            <tr>
                <td>Number of Damaged Pages</td>
                <td>{{ $condition->num_damaged_pages }}</td>
            </tr>
            <tr>
                <td>Broken Spine</td>
                <td>{{ $condition->broken_spine }}</td>
            </tr>
            <tr>
                <td>Broken Binding</td>
                <td>{{ $condition->broken_binding }}</td>
            </tr>
            <tr>
                <td>Water Damage</td>
                <td>{{ $condition->water_damage }}</td>
            </tr>
            <tr>
                <td>Stains</td>
                <td>{{ $condition->stains }}</td>
            </tr>
            <tr>
                <td>Burns</td>
                <td>{{ $condition->burns }}</td>
            </tr>
            <tr>
                <td>Rips</td>
                <td>{{ $condition->rips }}</td>
            </tr>
        </table>

    </div>

</div>
@endsection
