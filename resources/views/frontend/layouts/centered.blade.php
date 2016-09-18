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
    @include('partials.favicon')

    <!-- Styles -->
    @yield('head.styles.before', '')
    <link href="{{ elixir('assets/css/frontend/app.css') }}" rel="stylesheet">
    @yield('head.styles.after', '')

    {{-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
<script src="{{ elixir('assets/js/frontend/app.js') }}"></script>
@yield('foot.scripts.after', '')

</body>
</html>
