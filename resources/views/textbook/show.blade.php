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
            @include('includes.textbook.book-details-with-actions')
        </div>

        @if(count($products) > 0)
            <div class="row">
                <div class="col-xs-12 bar">
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
                                    All University / College
                                @endif
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuFilterBy">
                                <li><a href="{{ Request::url().'?query='.$query.'&order='.$order }}">All University / College</a></li>
                                @foreach($universities as $u)
                                    <li><a href="{{ Request::url().'?query='.$query.'&order='.$order.'&university_id='.$u->id }}">{{ $u->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Product list --}}
            <div class="row">
                <div class="col-xs-12">
                    <table class="table" data-sortable>
                            <thead>
                            <tr>
                                <th class="col-xs-2">Price</th>
                                <th class="col-xs-2">Condition</th>
                                <th class="col-xs-6 hidden-xs">Images</th>
                                <th class="col-xs-2"></th>
                            </tr>
                            </thead>

                            <?php $loggedin = Auth::check();?>

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
                                        <a href="{{ url('textbook/buy/product/'.$product->id.'?query='.$query) }}" class="btn btn-info btn-block margin-bottom-5">View details</a>

                                        @if($loggedin)
                                            @if($product->isInCart(Auth::user()->id))
                                                <a class="btn btn-success btn-block add-cart-btn disabled" href="#" role="button">
                                                    <span class="glyphicon glyphicon-ok"></span>
                                                    Added to cart
                                                </a>
                                            @elseif(!$product->isSold())
                                                @if($product->seller_id != Auth::id())
                                                    <form method="post" class="add-to-cart" action="{{ url('cart/add/' . $product->id) }}">
                                                        {!! csrf_field() !!}
                                                        <button type="submit" class="btn btn-default btn-block add-cart-btn">
                                                            <span class="glyphicon glyphicon-shopping-cart"></span> Add to cart
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                </div>
            </div>
        @else
            @if(!App\BookReminder::exists($book->id, Auth::id()))
                <form action="{{ url('textbook/reminder') }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="submit" class="btn btn-warning" value="Remind me when this book is available">
                </form>
            @endif
        @endif

    </div>

@endsection
