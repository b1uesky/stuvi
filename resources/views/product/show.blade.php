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



    </div>

</div>
@endsection
