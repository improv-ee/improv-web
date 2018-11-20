@if (config('app.env') === 'staging')
    <div class="alert alert-warning text-center" role="alert">
        <srong>@lang('site.staging_warning')</srong>
    </div>
@endif

<header class="blog-header py-3">
    <div class="row align-items-center">
        <div class="col-12 col-md-8 text-center">
            <h1><a href="/">{{ config('app.name') }}</a></h1>
        </div>
        <div class="col-12 col-md-4 align-items-center">
            @yield('topright')
        </div>
    </div>
</header>
