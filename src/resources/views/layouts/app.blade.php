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
<script type="application/json" id="app-config">{!! appConfigJson() !!}</script>
@yield('scripts')
</body>
</html>
