<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>Météo - @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        @section('sidebar')
        @show

        <main class="container">
            @yield('content')
        </main>
        @stack('scripts')
    </body>
</html>