@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resumeister</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container">
        <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="login">
            <div class="header" style="margin-top: 40px">
                <img src="{{ asset('assets/img-bg/resumeister.png') }}">
            </div>
            <div class="header">
                <h1>Welcome Back</h1>
            </div>
            <br><br>
            <div class="input">
                <input type="text" name="username" placeholder="Username" required>
            </div><br><br>
            <div class="input">
                <input type="password" name="password" placeholder="Password" required>
            </div><br><br><br>
            <div class="input">
                <button type="submit" name="submit">Log in</button>
            </div>   
            <div class="signup">
                <p>Sign Up</p>
            </div>            
        </div>
    </form>
    </div>
</body>
</html>
@endsection