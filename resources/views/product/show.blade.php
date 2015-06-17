@extends('product')

@section('content')
<head>
    <title>Stuvi - Book Details</title>
    <link rel="stylesheet" href="{{asset('/css/product-show.css')}}" type="text/css">
</head>



<div class="container-fluid" id="bg">
{{--    <div class="row back-row">
        <a id="go-back" href="" onclick="goBack()" ><i class="fa fa-arrow-circle-left"></i> Back to {{ $book->title }}</a>
    </div>--}}

    <div class="container" id="det-cont">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <h2>{{ $book->title }}</h2>
                <!-- TODO: Link to Seller profile -->
                <h4>Sold by <a href="#">{{$product->seller->first_name}} {{$product->seller->last_name}}</a></h4>

                @if(!empty($images))
                    @foreach($images as $image)
                        <div class="">
                            <img src="{{ $image->path }}" alt="" />
                        </div>
                    @endforeach
                @endif

                <div class="price">
                    Price: <b>${{ $product->price }}</b>
                </div>

                <a class="btn add-cart-btn" href="{{ url('/cart/add/'.$product->id) }}">Add to Cart</a>

            </div>

            <table class="table table-responsive details-table col-sm-12 col-md-6">
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

            @if($condition->description != '')
                <h4>Seller's description on the book conditions:</h4>
                <div class="">
                    {{ $condition->description }}
                </div>
            @endif

        </div>
    </div>

</div>


<script>
    function goBack() {
        window.history.back();
    }
</script>
@endsection
