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

            <a href="{{ url('textbook/sell/product/create/'.$book->id) }}">
                Sell Book
            </a>
        </div>


    </div>
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection