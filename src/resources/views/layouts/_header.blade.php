@if (config('app.env') === 'staging')
    <div class="alert alert-warning text-center" role="alert">
        <srong>@lang('site.staging_warning')</srong>
    </div>
@endif

<header class="blog-header py-3">
    <div class="row align-items-center">
        <div class="col-12 col-md-8">
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
