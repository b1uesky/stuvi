@extends('textbook')


@section('content')
    <div class="container">
        <div class="row">
            @if($book->imageSet->large_image)
                <img src="{{ $book->imageSet->large_image }}" alt="" />
            @endif

            <div class="">
                ISBN: {{ $book->isbn }}
            </div>

            <div class="">
                Title: {{ $book->title }}

            </div>

            <div class="">
                Edition: {{ $book->edition }}
            </div>

            {{-- Author(s) --}}
            {{-- TODO: Make each author name looks like a tag --}}
            <div class="">
                @if(count($book->authors) > 1)
                    <span>Authors:</span>
                    @foreach($book->authors as $author)
                        <span>{{ $author->full_name }}</span>
                    @endforeach
                @else
                    <span>Author:</span>
                    {{ $book->authors[0]->full_name }}
                @endif
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

                @foreach($book->products as $product)
                    <tr>
                        <td>
                            {{ $product->price }}
                        </td>
                        <td>
                            {{-- TODO: product condition score --}}
                        </td>
                        <td>
                            <a href="{{ url('textbook/buy/product/'.$product->id) }}">Details</a>
                        </td>

                    </tr>
                @endforeach

            </table>


        </div>
    </div>

@endsection
