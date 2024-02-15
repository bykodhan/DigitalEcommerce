<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@stack('title') | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('vendor/bs5/bootstrap.min.css') }}">
    @stack('head')
</head>

<body>
    @yield('content')
    <script src="{{ asset('vendor/bs5/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
