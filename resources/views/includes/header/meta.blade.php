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
