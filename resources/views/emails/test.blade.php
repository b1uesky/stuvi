@extends('beautymail::templates.widgets')

@section('content')

    @include('beautymail::templates.widgets.articleStart', ['color' => '#81D8D0'])

        <h4 class="secondary"><strong>Hello World</strong></h4>
        <p>This is a test</p>

    @include('beautymail::templates.widgets.articleEnd')

@stop
