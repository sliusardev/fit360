<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{$seoDescription ?? $settings['seo_description'] ?? ''}}">
    <meta name="keywords" content="{{$seoKeyWords ?? $settings['seo_text_keys'] ?? ''}}">
    <title>
        {{$settings['site_name'] ?? ''}} - {{!empty($title) ? $title . ' - ' . $settings['seo_title'] ?? '' : $settings['seo_title'] ?? '' }}
    </title>

    <meta name="author" content="Олександр Пузій">
    <meta name="image" content="{{asset('assets/images/header/fit360_logo.jpg')}}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Fit360 фітнес студія у Полтаві">
    <meta property="og:description" content="Fit360 фітнес студія у Полтаві">
    <meta property="og:image" content="{{asset('assets/images/header/fit360_logo.jpg')}}">
    <meta property="og:url" content="{{env('APP_URL')}}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/images/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/images/favicon/site.webmanifest')}}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('custom-header')
</head>
<body>

<div class="container my-4">
    <x-admin-top-line/>

    <div class="text-center my-4">
        <div>
            <a href="/">
                <img src="{{asset('assets/images/header/fit360_logo.jpg')}}" alt="fit360" class="img-fluid" width="336"
                     height="201">
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

    @include('site.inc.bottom-mobile-menu')
</div>
@stack('custom-footer')
</body>
</html>


