<header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-4"></div>
        <div class="col-4 text-center">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="col-4 d-flex justify-content-end align-items-center">
            @yield('topright')
        </div>
    </div>
</header>
