<html>
<body>
<p>Welcome to Stuvi, {{ $user['first_name'] }}!</p>
<a href="{{ url('/user/activate/'.$user['activation_code']) }}">Please activate your account.</a>
</body>
</html>