<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts._meta')

    <title>@yield('title')</title>

    @yield('styles')

</head>
<body>

<div class="container">

    @include('layouts._header')

    @yield('content')

</div>
@yield('scripts')
</body>
</html>
