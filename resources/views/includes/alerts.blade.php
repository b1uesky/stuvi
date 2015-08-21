<div class="container">

    {{-- Session alert --}}
    <div class="row session-alert">

        @if(Session::has('success'))
            <div class="alert alert-dismissible alert-success fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get('success') }}
            </div>
        @endif

        @if(Session::has('info'))
            <div class="alert alert-dismissible alert-info fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get('info') }}
            </div>
        @endif

        @if(Session::has('warning'))
            <div class="alert alert-dismissible alert-warning fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get('warning') }}
            </div>
        @endif

        @if(Session::has('danger'))
            <div class="alert alert-dismissible alert-danger fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get('danger') }}
            </div>
        @endif

        {{-- invalid form data --}}
        @foreach ($errors->all() as $error)
            <div class="alert alert-warning" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ $error }}
            </div>
        @endforeach
    </div>

    {{-- JS alert --}}
    <div class="row js-alert">
        {{-- Use alert module (js/alert.js) to append message to this container --}}
    </div>

</div>