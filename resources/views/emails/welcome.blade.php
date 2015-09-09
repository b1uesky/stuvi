@extends('beautymail::templates.widgets')

@section('content')

    @include('beautymail::templates.widgets.articleStart', ['color' => '#81D8D0'])

        <h4 class="secondary">
            <strong>Welcome to Stuvi, {{ $first_name }}!</strong>
        </h4>

        <p>Please <a href="{{ url('/user/activate/'.$verification_code.'?return_to='.$return_to)}}" target="_blank">click here</a> verify your Email address.</p>

    @include('beautymail::templates.widgets.articleEnd')

@stop
