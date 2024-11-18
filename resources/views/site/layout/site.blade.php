<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}} фітнеc студія в Полаві</title>

    <meta name="description" content="Fit360 фітнес студія у Полтаві">
    <meta name="keywords" content="fit360, fitnes, poltava, полтаваб фітнес, спорт, тренування">
    <meta name="author" content="Олександр Пузій">
    <meta name="image" content="{{asset('assets/images/header/fit360_logo.jpg')}}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Fit360 фітнес студія у Полтаві">
    <meta property="og:description" content="Fit360 фітнес студія у Полтаві">
    <meta property="og:image" content="{{asset('assets/images/header/fit360_logo.jpg')}}">
    <meta property="og:url" content="{{env('APP_URL')}}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="container my-4">
    <x-admin-top-line/>

    <div class="text-center my-4">
        <div>
            <a href="/">
                <img src="{{asset('assets/images/header/fit360_logo.jpg')}}" loading="lazy" alt="fit360" class="img-fluid" loading="lazy" width="336" height="201">
            </a>

            <div>
                {!! $settings['slogan'] ?? '' !!}
            </div>

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

</body>
</html>


