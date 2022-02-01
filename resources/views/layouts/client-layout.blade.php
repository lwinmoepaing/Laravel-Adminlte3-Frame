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

    <link rel="icon" href="{{ URL('/uab.ico') }}" sizes="32x32" />
    <link rel="icon" href="{{ URL('/uab.ico') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ URL('/uab.ico') }}" />
    <meta name="msapplication-TileImage" content="{{ URL('/uab.ico') }}" />

    @stack('head-scripts')

</head>
<body>
    <div class="">
        @yield('content')
    </div>

    <script src="{{ URL::asset ('js/app.js') }}"></script>

    @stack('body-scripts')
</body>
</html>
