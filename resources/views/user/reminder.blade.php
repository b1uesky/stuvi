@extends('layouts.textbook')

@section('title','Reminder Settings')

@section('content')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Reminder settings</li>
            </ol>
        </div>

        <div class="row page-content">
            {{-- Left nav--}}
            <div class="col-sm-3">
                @include('includes.textbook.settings-panel')
            </div>

            {{-- Right content --}}
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Textbook reminders</h3>
                    </div>
                    <div class="panel-body">
                        @foreach($book_reminders as $br)
                            <div class="row">
                                <div class="col-sm-9 margin-bottom-15">
                                    <?php $book = $br->book; ?>
                                    @include('includes.textbook.book-details')
                                </div>

                                <div class="col-sm-3">
                                    <form action="{{ url('textbook/reminder/'.$br->id) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-default btn-sm btn-block">
                                            <span class="glyphicon glyphicon-remove"></span> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection