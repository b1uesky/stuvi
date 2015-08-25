{{-- The bookshelf page shows all the seller's books for sale, but not yet purchased --}}

@extends('layouts.textbook')

@section('title','Bookshelf')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/user_bookshelf.css')}}">
@endsection

@section('content')
    @include('user-template')

    <div class="col-md-9 bookshelf-page">
        <div class="profile-content bookshelf-content">

            <div class="bookshelf-title-container">
                <h1 id="bookshelf-title">Your Bookshelf</h1>
                <h4 id="bookshelf-title-subtext">Your books for Sale</h4>
            </div>
            <!-- books -->
            <div class="container col-sm-11 col-md-12 for-sale-table-container">
                <table class="table table-responsive for-sale-table">
                    @forelse ($productsForSale as $product)
                        <tr class="for-sale-item">
                            <td class="for-sale-img">
                                @if($product->book->imageSet->isManuallyCreated())
                                   <a href="{{ url('textbook/buy/product/'.$product->id) }}" class="for-sale-img-link">
                                        <img class="img-responsive for-sale-image" src="{{ config('aws.url.stuvi-book-img') . $product->book->imageSet->medium_image }}"
                                             width="100px"
                                             height="150px">
                                   </a>
                                @else
                                     <a href="{{ url('textbook/buy/product/'.$product->id) }}">
                                        <img class="img-responsive" src="{{ $product->book->imageSet->medium_image or config('book.default_image_path.medium') }}"
                                            width="100px"
                                            height="150px">
                                     </a>
                                @endif
                            </td>
                            <td class="for-sale-info-1" colspan="2">
                            <span class="for-sale-title"><a
                                        href="{{ url('textbook/buy/product/'.$product->id) }}">{{ $product->book->title }}</a></span><br>
                                <?php $i = 0 ?>
                                @foreach($product->book->authors as $author)
                                    @if($i == 0)
                                        <span class="for-sale-by">by </span>
                                        <span class="for-sale-author">{{ $author->full_name }}</span>
                                        <?php $i++ ?>
                                    @else
                                        <span class="for-sale-author">, {{ $author->full_name }}</span>
                                    @endif
                                @endforeach
                                <br>
                                <span class="for-sale-binding">Hardcover</span><br>
                                <span class="for-sale-price">${{ $product->decimalPrice() }}</span> <br>
                            </td>
                            <td class="for-sale-info-2">
                                <span class="for-sale-isbn">ISBN-10: {{ $product->book->isbn10 }}</span><br>
                                <span class="for-sale-isbn">ISBN-13: {{ $product->book->isbn13 }}</span><br>
                                <span class="for-sale-isbn">
                                    <a href="{{ url('/textbook/sell/product/'.$product->id.'/edit') }}"
                                       class="btn btn-primary edit-btn">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                </span>

                                <form action="{{ url('/textbook/sell/product/delete') }}" method="post"
                                      class="delete-form">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-primary sell-btn">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>

                            {{--<td class="for-sale-info-3">--}}
                            {{--<!-- each class the book support -->--}}
                            {{--<h5>Classes</h5>--}}
                            {{--<span class="for-sale-class"><a href="#">BU:SMG SM131</a></span>--}}
                            {{--</td>--}}
                        </tr>
                    @empty
                        <div class="empty"><br>You don't have books for sale.</div>
                    @endforelse
                </table>
            </div>
            {{--        <h1>Your buyer orders:</h1>
                    @forelse ($orders as $order)
                        <div class="row">
                        <li><a href="{{ url('order/buyer/'.$order->id) }}">Order #{{ $order->id }}</a></li>
                            --}}{{--
                        <li>{{ $order->buyer_payment()->stripe_amount/100 }}</li>
                        <p>Product info:</p><br>
                        <li>{{ $order->product->book->title }}</li>
                        <li>{{ $order->product->book->isbn }}</li>
                        <li>{{ $order->product->book->author }}</li>
                        --}}{{--
                        --------------------------------------------------------------<br>
                        </div>
                    @empty
                        <p>You don't have any orders.</p>
                    @endforelse--}}
        </div>
    </div>
    {{--need these closing tags--}}
    </div>
    </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{asset('js/user/bookshelf.js')}}"></script>
@endsection