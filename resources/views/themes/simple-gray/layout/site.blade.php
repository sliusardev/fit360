<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @includeIf('includes.header.meta')
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .sidebar-hidden {
            transform: translateX(100%);
        }
    </style>

    @stack('custom-header')
</head>
<body class="flex flex-col items-center justify-center min-h-screen relative">

    <div class="w-full max-w-lg p-4 flex-grow mb-16">

        @include('themes.simple-gray.inc.header-section')
        @include('themes.simple-gray.inc.alerts')

        @yield('content')

    </div>

    @include('themes.simple-gray.inc.sidebar-menu')
    @include('themes.simple-gray.inc.footer')
    @stack('custom-footer')
</body>
</html>


