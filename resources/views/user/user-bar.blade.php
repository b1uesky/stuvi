<html>
    <head>

    <link rel="stylesheet" href="{{asset('/css/user-bar.css')}}"
    </head>

    <body>

    <div class="container" id = "user-bar">
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="active"><a href="{{url('/user/profile')}}">Profile</a></li>
            <li><a href="{{url('/user/account')}}">Account</a></li>
            <li><a href="#">Orders</a></li>
            <li class = "disabled"><a href="#">Clubs</a></li>
            <li class = "disabled"><a href="#">Groups</a></li>
        </ul>
    </div>


    </body>



</html>
