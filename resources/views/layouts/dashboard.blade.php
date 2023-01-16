<!DOCTYPE html>
<html>

<head>
    @include('partials.dashhead')
</head>

<body id="home" class="home-page d-flex flex-column min-vh-100">
<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <header class="header">
            @include('partials.dashheader')
        </header>
        <main>
        <div id="main">
        @include('partials.dashboardsidebar')
            @yield('content')
        </div>
        </main>
        <div class="wrapper flex-grow-1"></div>
        <footer>
            @include('partials.dashfooter')
        </footer>
        
</body>
@yield('scripts')
</html>