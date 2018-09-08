<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
            <h1 class="display-4 font-italic">Title of a longer featured blog post</h1>
            <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what's most interesting in this post's contents.</p>
            <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12"><h3>Kolmapäev, 12 Oktoober</h3></div>
    </div>

    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-primary">World</strong>
                    <h3 class="mb-0">
                        <a class="text-dark" href="#">Featured post</a>
                    </h3>
                    <div class="mb-1 text-muted">Nov 12</div>
                    <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                    <a href="#">Continue reading</a>
                </div>
                <img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-success">Design</strong>
                    <h3 class="mb-0">
                        <a class="text-dark" href="#">Post title</a>
                    </h3>
                    <div class="mb-1 text-muted">Nov 11</div>
                    <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                    <a href="#">Continue reading</a>
                </div>
                <img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12"><h3>Kolmapäev, 12 Oktoober</h3></div>
    </div>

    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-primary">World</strong>
                    <h3 class="mb-0">
                        <a class="text-dark" href="#">Featured post</a>
                    </h3>
                    <div class="mb-1 text-muted">Nov 12</div>
                    <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                    <a href="#">Continue reading</a>
                </div>
                <img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-success">Design</strong>
                    <h3 class="mb-0">
                        <a class="text-dark" href="#">Post title</a>
                    </h3>
                    <div class="mb-1 text-muted">Nov 11</div>
                    <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                    <a href="#">Continue reading</a>
                </div>
                <img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap">
            </div>
        </div>
    </div>


    <footer>
        <p>improv.ee {{ date('Y') }}</p>
    </footer>
</div>

</body>
</html>
