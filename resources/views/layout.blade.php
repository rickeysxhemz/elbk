<!DOCTYPE HTML>
<html>
    <head>
        <title>@yield('title') | Elegant Lashes by Katie</title>

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css" />
    </head>

    <body>
        <header>
            <a href="/"><img id="logo" src="/img/logo_colored_cropped.png" /></a>
        </header>

        <main>
            @yield('content')
        </main>

        @yield('scripts')
    </body>
</html>