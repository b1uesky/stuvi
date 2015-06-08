@extends('textbook')


@section('content')
    <div class="container">
        <div class="row">
            <div class="">
                ISBN: {{ $book->isbn }}
            </div>
            <div class="">
                Title: {{ $book->title }}
            </div>
            <div class="">
                Edition: {{ $book->edition }}
            </div>
            <div class="">
                Author: {{ $book->author }}
            </div>
            <div class="">
                Number of Pages: {{ $book->num_pages }}
            </div>

            <hr>

            <table style="width:100%" border="1">
                <caption>Available Textbooks</caption>
                <tr>
                  <th>Price</th>
                  <th>Condition</th>
                </tr>

                @foreach($products as $product)
                    <tr>
                        <td>
                            {{ $product->price }}
                        </td>
                        <td>
                            {{-- TODO: product condition score --}}
                        </td>
                        <td>
                            <a href="{{ url('textbook/buy/product/'.$product->id) }}">Buy</a>
                        </td>

                    </tr>
                @endforeach

            </table>


        </div>
    </div>

@endsection
