{{-- /textbook/buy/# --}}

@extends('layouts.textbook')

@section('title',$book->title)

@section('content')

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>

                <li>
                    <a href="{{ url('textbook/search?query=' . $query) }}">Search results</a>
                </li>

                <li class="active">{{ $book->title }}</li>
            </ol>
        </div>

        <div class="book-details">
            @include('includes.textbook.book-details')
        </div>

        <div class="row bar">

            <div class="action-bar">
                @if(Auth::guest())
                    <div class="text-muted">
                        Please <a data-toggle="modal" href="#login-modal">Login</a> or
                        <a data-toggle="modal" href="#signup-modal">Sign up</a> to buy or sell this textbook.
                    </div>
                @else
                    <a href="{{ url('textbook/sell/product/'.$book->id.'/create') }}" class="btn btn-default btn-no-border">
                        <strong>Have one to sell?</strong>
                    </a>
                @endif
            </div>


                <div class="sort-bar">
                    <div class="dropdown">
                        <button class="btn btn-default btn-no-border dropdown-toggle" id="dropdownMenuOrderBy" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span><strong>Sort by </strong></span>
                            <span class="sort-by-type">
                                @if($order)
                                    {{ $order }}
                                @else
                                    Condition
                                @endif
                            </span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuOrderBy">
                            <li><a href="{{ Request::url().'?query='.$query.'&order=condition'.'&university_id='.$university_id }}">Condition</a></li>
                            <li><a href="{{ Request::url().'?query='.$query.'&order=price'.'&university_id='.$university_id }}">Price</a></li>
                        </ul>
                    </div>
                </div>



                <div class="filter-bar">

                    <div class="dropdown">
                        <button class="btn btn-default btn-no-border dropdown-toggle" id="dropdownMenuFilterBy" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php $university = \App\University::find($university_id); ?>
                            <span class="filter-by"><strong>Available at </strong></span>

                            @if($university)
                                {{ $university->abbreviation }}
                            @else
                                University / College
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuFilterBy">
                            <li><a href="{{ Request::url().'?query='.$query.'&order='.$order }}">All</a></li>
                            @foreach($universities as $u)
                                <li><a href="{{ Request::url().'?query='.$query.'&order='.$order.'&university_id='.$u->id }}">{{ $u->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>


            {{--<div class="col-md-4">--}}
                {{--<div class="action-bar">--}}
                    {{--@if(Auth::guest())--}}
                        {{--<div class="text-muted">--}}
                            {{--Please <a data-toggle="modal" href="#login-modal">Login</a> or--}}
                            {{--<a data-toggle="modal" href="#signup-modal">Sign up</a> to buy or sell this textbook.--}}
                        {{--</div>--}}
                    {{--@else--}}
                        {{--<a href="{{ url('textbook/sell/product/'.$book->id.'/create') }}" class="alert-link">Have one to sell?</a>--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>

        {{-- Product list --}}
        <div class="row">
            @if(count($products) > 0)
                <table class="table" data-sortable>
                    <thead>
                    <tr class="active">
                        <th class="col-xs-2">Price</th>
                        <th class="col-xs-2">Condition</th>
                        <th class="col-xs-6 hidden-xs">Images</th>
                        <th class="col-xs-2"></th>
                    </tr>
                    </thead>
                    @foreach($products as $product)
                        <tr>
                            <td class="price">
                                ${{ $product->decimalPrice() }}
                            </td>
                            <td>
                                {{ $product->general_condition() }}
                            </td>
                            <td class="container-flex hidden-xs">
                                @foreach($product->images as $image)
                                    <div>
                                        <img class="img-rounded img-small margin-5 full-width"
                                             src="{{ $image->getImagePath('large') }}"
                                             data-action="zoom">
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ url('textbook/buy/product/'.$product->id.'?query='.$query) }}">View details</a>
                            </td>
                        </tr>
                    @endforeach

                </table>
            @endif
        </div>


    </div>

@endsection