<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="d-flex vh-100">
        @include('admin.partials.aside')
        <div class="flex-grow-1 d-flex flex-column">
            @include('admin.partials.header')
            <main class="flex-grow-1 p-4 overflow-auto">
                @yield('content')
            </main>
            @yield('actions')
    </div>
    </div>
</body>
</html>