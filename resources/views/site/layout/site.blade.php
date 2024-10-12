<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <meta name="description" content="Fit360 фітнес студія у Полтаві">
    <meta name="keywords" content="fit360, fitnes, poltava, полтаваб фітнес, спорт, тренування">
    <meta name="author" content="Олександр Пузій">
    <meta name="image" content="{{asset('assets/images/header/fit360_logo.jpg')}}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Fit360 фітнес студія у Полтаві">
    <meta property="og:description" content="Fit360 фітнес студія у Полтаві">
    <meta property="og:image" content="{{asset('assets/images/header/fit360_logo.jpg')}}">
    <meta property="og:url" content="{{env('APP_URL')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Sofia+Sans:ital,wght@0,1..1000;1,1..1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Sofia Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container my-4">
    <x-admin-top-line/>

    <div class="text-center my-4">
        <div>
            <a href="/">
                <img src="{{asset('assets/images/header/fit360_logo.jpg')}}" alt="fit360" class="img-fluid">
            </a>

        </div>

        @guest
            <h6>Вітаю! Спробуй <a href="/panel/login">Увійти</a>, або <a href="/panel/register">Зареєструйся</a></h6>
        @endguest

        @auth
            <h3>
                Вітаю, {{auth()->user()->name}}
            </h3>

        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show p-o" role="alert">
            {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


