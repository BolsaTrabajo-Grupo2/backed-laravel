<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;


            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
            background: url('/fondoHomeBackend.jpg') center/cover no-repeat fixed;
        }

        h1 {
            color: white;
            font-size: 300%;
            text-align: center;
            margin-top: 30px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 15%;
        }

        .login {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: #fff;
            font-size: 18px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .login:hover {
            background-color: #2779bd;
        }
    </style>
    <title>Backend</title>
</head>
<body class="antialiased">
<h1>Backend de la bolsa de trabajo</h1>
<div class="login-container">
    @if (Route::has('login'))
        <div class="login">
                <a href="{{ route('login') }}" class="login">Log in</a>
        </div>
    @endif
</div>
</body>
</html>
