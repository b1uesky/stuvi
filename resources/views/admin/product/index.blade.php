@extends('layouts.admin')

@section('title', 'Product')


@section('content')

    <table class="table table-condensed" data-sortable>
        <thead>
            <tr class="active">
                <th>ID</th>
                <th>Book Title</th>
                <th>Price</th>
                <th>Seller</th>
                {{--<th>Verified</th>--}}
                {{--<th>Rejected</th>--}}
                <th>Sold</th>
                <th>Accept trade-in</th>
                <th>Images</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><a href="{{ url('admin/book/'.$product->book->id) }}">{{ $product->book->title }}</a></td>
                    <td class="price">
                        @if($product->price)
                            ${{ $product->decimalPrice() }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td><a href="{{ url('/admin/user/'.$product->seller->id) }}">{{ $product->seller->first_name }} {{ $product->seller->last_name }}</a></td>
                    {{--<td>{{ $product->isVerified() }}</td>--}}
{{--                    <td>{{ $product->is_rejected ? 'Yes' : 'No' }}</td>--}}
                    <td>{{ $product->sold ? 'Yes' : 'No' }}</td>
                    <td>{{ $product->accept_trade_in ? 'Yes' : 'No' }}</td>
                    <td class="container-flex">
                        @foreach($product->images as $image)
                            <div>
                                <img class="img-rounded img-small margin-5 full-width"
                                     src="{{ $image->getImagePath('large') }}"
                                     data-action="zoom">
                            </div>
                        @endforeach
                    </td>


                    <!-- we will also add show, edit, and delete buttons -->
                    <td>

                        <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                        <!-- we will add this later since its a little more complicated than the other two buttons -->

                        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                        <div class="btn-group-vertical" role="group">
                            <a href="{{ url('admin/product/' . $product->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a>
                            {{--@if(!$product->verified)--}}
                            {{--<a class="btn btn-success btn-block" role="button"--}}
                            {{--href="{{ url('admin/product/' . $product->id . '/approve') }}">Approve</a>--}}
                            {{--@else--}}
                            {{--<a class="btn btn-warning btn-block" role="button"--}}
                            {{--href="{{ url('admin/product/' . $product->id . '/disapprove') }}">Disapprove</a>--}}
                            {{--@endif--}}
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>


    </table>

    {!! $products->appends($pagination_params)->render() !!}
@endsection