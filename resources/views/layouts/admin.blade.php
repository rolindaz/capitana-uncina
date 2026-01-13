<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    @include('partials.header')
    <div class="container">
        <h1 class="mt-4">
            @yield('title')
        </h1>
        @yield('actions')
        @yield('content')
    </div>
</body>
</html>