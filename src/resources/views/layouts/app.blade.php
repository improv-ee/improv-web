<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>improv - @yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />

</head>
<body>


<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4"></div>
            <div class="col-4 text-center">
                <h1>Improteater Eestis</h1>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">

                <a class="btn btn-sm btn-outline-secondary" href="#">Logi sisse</a>
            </div>
        </div>
    </header>


    <div class="py-1 mb-2">
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Etendused</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Töötoad</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Jämmid</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Õppimine</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Trupid</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Kutsu esinema</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Podcast</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Uudiskiri</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Mis on impro?</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Teenused truppidele</a>
        </nav>
    </div>

    @yield('content')


    <footer>
        <p>improv.ee {{ date('Y') }}</p>
    </footer>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
