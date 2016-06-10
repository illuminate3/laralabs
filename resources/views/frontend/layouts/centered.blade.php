<!DOCTYPE html>
<html lang="en" class="fullscreen-bg">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title and properties -->
    <title>@yield('head.title', 'Laralabs')</title>

    <!-- Favicon -->
    {{-- TODO --}}

    <!-- Styles -->
    @yield('head.styles.before', '')
    <link href="{{ elixir('css/frontend/app.css') }}" rel="stylesheet">
    @yield('head.styles.after', '')
</head>
<body>

<!-- Page content -->
<div class="vertical-center">
    <div class="container">
        @yield('page.content')
    </div>
</div>

<!-- Scripts -->
@yield('foot.scripts.before', '')
<script src="{{ elixir('js/frontend/app.js') }}"></script>
@yield('foot.scripts.after', '')

</body>
</html>
