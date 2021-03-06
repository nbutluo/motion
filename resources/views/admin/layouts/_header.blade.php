<!-- Logo -->
<a href="{{ route('admin.index') }}" class="logo">
    <span class="logo-lg"><b>Loctek</b>Motion</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        {{ Session::get('user')}} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <button type="submit" class="btn btn-block btn-danger bnt-sm">退 出</button>
                    </ul>
                </li>
            </ul>
        </div>
    </form>
</nav>
