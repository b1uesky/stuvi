<div class="container">

    {{-- Session alert --}}
    <div class="row session-alert">

        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        @if(Session::has('info'))
            <div class="alert alert-info" role="alert">
                {{ Session::get('info') }}
            </div>
        @endif

        @if(Session::has('warning'))
            <div class="alert alert-warning" role="alert">
                {{ Session::get('warning') }}
            </div>
        @endif

        @if(Session::has('danger'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('danger') }}
            </div>
        @endif

        {{-- invalid form data --}}
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    </div>

    {{-- JS alert --}}
    <div class="row js-alert">

    </div>

</div>