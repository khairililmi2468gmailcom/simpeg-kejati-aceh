<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://unpkg.com/htmx.org@1.9.5"></script>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    @yield('content')
</body>

</html>
