<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Stuvi Admin</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <form class="navbar-form navbar-left" action="{{ url(Request::path()) }}" method="get">
                <div class="form-group">
                    <select name="filter" class="form-control">
                        @foreach($filters as $filter)
                            <option value="{{ $filter }}" @if ($pagination_params['filter'] == $filter) selected @endif>{{ $filter }}</option>
                        @endforeach
                    </select>
                </div> <!-- form group [rows] -->
                <div class="form-group">
                    <input type="text" class="form-control" name="keyword" value="{{ $pagination_params['keyword'] }}">
                </div><!-- form group [search] -->
                <div class="form-group">
                    <button type="submit" class="btn btn-default">
                        Search
                    </button>
                </div>
            </form>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="dropdownMenuAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="glyphicon glyphicon-user"></span> {{ Auth::user()->first_name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuAdmin">
                        <li><a href="{{ url('auth/logout') }}">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>