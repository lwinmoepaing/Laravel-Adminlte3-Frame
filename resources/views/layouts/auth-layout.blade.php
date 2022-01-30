<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" href="{{ URL::asset ('css/app.css') }}">
    <link rel="stylesheet" href="{{ URL::asset ('css/custom.css') }}">
    <script src="{{ URL::asset ('js/app.js') }}"></script>
    @stack('head-scripts')

</head>
<body id="login">
    @yield('content')
    @stack('body-scripts')
</body>
</html>