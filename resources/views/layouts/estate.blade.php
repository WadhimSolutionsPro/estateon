<!DOCTYPE html>
<html>

<head>
    @include('partials.webhead')
</head>

<body id="home" class="home-page d-flex flex-column min-vh-100">
        <header class="header">
            @include('partials.webheader')
        </header>
        <main>
        <div id="main">
            @yield('content')
        </div>
        </main>
        <div class="wrapper flex-grow-1"></div>
        <footer>
            @include('partials.webfooter')
        </footer>
        
</body>
@yield('scripts')
</html>