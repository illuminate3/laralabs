<!DOCTYPE html>
<html lang="{{ config('app.locale') }}"> {{-- TODO Output the current locale, not the config locale --}}
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Title and properties -->
    <title>@yield('head.title', 'Laralabs')</title>

    <!-- Favicon -->
    @include('partials.favicon')

    <!-- Styles -->
    @yield('head.styles.before', '')
    <link href="{{ elixir('assets/css/backend/app.css') }}" rel="stylesheet">
    @yield('head.styles.after', '')

    {{-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-black-light sidebar-mini">

<!-- Page wrapper -->
<div class="wrapper">

    @include('backend.layouts.partials.master.primary-header')
    @include('backend.layouts.partials.master.primary-sidebar')

    <!-- Content Wrapper -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        @section('page.header')
            <section class="content-header">
                <h1>
                    Page Header
                    <small>Optional description</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                    <li class="active">Here</li>
                </ol>
            </section>
        @show

        <!-- Main content -->
        <section class="content">
            @yield('page.content')
        </section>
    </div>

    @include('backend.layouts.partials.master.primary-footer')
</div>

<!-- Scripts -->
@yield('foot.scripts.before', '')
<script src="{{ elixir('assets/js/backend/app.js') }}"></script>
@yield('foot.scripts.after', '')

</body>
</html>
