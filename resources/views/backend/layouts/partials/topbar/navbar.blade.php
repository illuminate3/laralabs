<nav class="navbar navbar-static-top" role="navigation">

    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">{{ trans('views.backend.general.toggle_nav') }}</span>
    </a>

    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

            <!-- Messages -->
            @include('backend.layouts.partials.topbar.navbar-messages')

            <!-- Notifications Menu -->
            @include('backend.layouts.partials.topbar.navbar-notifications')

            <!-- Tasks Menu -->
            @include('backend.layouts.partials.topbar.navbar-tasks')

            <!-- User Account Menu -->
            @include('backend.layouts.partials.topbar.navbar-account')

            <!-- Control Sidebar Toggle Button -->
            <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
        </ul>
    </div>
</nav>