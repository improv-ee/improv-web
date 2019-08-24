<header class="site-header py-3">
    <div class="row align-items-center">
        <div class="col-12 col-md-8">
            <img src="{{ asset('img/impro10.png') }}" alt="Impro 10" class="impro-10" />
            <h1>
                <a href="/">
                    <img src="{{ asset('img/logo.png') }}" height="50" alt="Logo" />    {{ config('app.name') }}
                </a>
            </h1>
        </div>
        <div class="col-12 col-md-4 align-items-end text-right">
            @yield('topright')
        </div>
    </div>
</header>
