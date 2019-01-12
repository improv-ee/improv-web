<footer class="page-footer font-small blue">
    <div class="container-fluid text-center text-md-left">
        <div class="row">
            <div class="col-md-6 mt-md-0 mt-3">
                <h5 class="text-uppercase">{{ config('app.name') }}</h5>
                <p>@lang('site.meta_description')</p>

            </div>

            <hr class="clearfix w-100 d-md-none pb-3">

            <div class="col-md-3 mb-md-0 mb-3">

                <h5 class="text-uppercase">@lang('site.about_us')</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="https://github.com/improvision-eu/improvision-web">GitHub</a>
                    </li>
                    <li>
                        <a href="https://github.com/improvision-eu/improvision-web/wiki/Reporting-bugs-and-feature-requests">@lang('site.report_bug')</a>
                    </li>
                </ul>

            </div>

            <div class="col-md-3 mb-md-0 mb-3">

                <h5 class="text-uppercase"> </h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="#!">&nbsp;</a>
                    </li>
                    <li>
                        <a href="#!">&nbsp;</a>
                    </li>
                    <li>
                        <a href="#!">&nbsp;</a>
                    </li>
                    <li>
                        <a href="#!">&nbsp;</a>
                    </li>
                </ul>

            </div>

        </div>

    </div>

    <div class="footer-copyright text-center">
        <p>@lang('site.footer_copyright_text')</p>
        <p>© 2013 - {{ date('Y') }}
        <a href="/humans.txt">@lang('site.footer_copyright_holder')</a></p>
    </div>
</footer>
