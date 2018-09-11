<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @yield('styles')


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
                @yield('topright')
            </div>
        </div>
    </header>

    @yield('content')


    <footer class="site-footer">
        <p>improv.ee 2013 - {{ date('Y') }}</p>
    </footer>
</div>
@yield('scripts')
</body>
</html>
