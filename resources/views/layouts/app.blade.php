<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/yarn(1).png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Permanent+Marker&family=Walter+Turncoat&display=swap" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>

<body>
    <div class="hooks d-flex justify-content-center align-items-center vh-100" id="app">
        <main class="welcome d-flex align-items-center justify-content-evenly">
            
            @yield('content')
        </main>



            
        <img src="{{ asset('storage/crochet.png') }}" alt="crossing_hooks" class="crochet">
    </div>
</body>

</html>
