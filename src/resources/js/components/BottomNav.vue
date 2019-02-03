<template>
        <footer class="page-footer font-small blue">
            <div class="container-fluid text-center text-md-left">
                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <h5 class="text-uppercase">{{ $t('app.name') }}</h5>
                        <p>{{ $t('site.meta_description') }}</p>

                    </div>

                    <hr class="clearfix w-100 d-md-none pb-3">

                    <div class="col-md-3 mb-md-0 mb-3">

                        <h5 class="text-uppercase">{{ $t('site.help_and_support') }}</h5>

                        <ul class="list-unstyled">

                            <li>
                                <a href="https://github.com/improvision-eu/improvision-web/wiki/Reporting-bugs-and-feature-requests"
                                   target="_blank">{{ $t('site.report_bug') }}</a>
                            </li>
                            <li>
                                <a href="/#/contact">{{ $t('nav.contact') }}</a>
                            </li>

                        </ul>

                    </div>

                    <div class="col-md-3 mb-md-0 mb-3">

                        <h5 class="text-uppercase">{{ $t('app.name') }}</h5>

                        <ul class="list-unstyled">
                            <li>
                                <a href="https://docs.improvision.eu" target="_blank">{{ $t('site.api_doc') }}</a>
                            </li>
                            <li>
                                <a href="https://github.com/improvision-eu/improvision-web" target="_blank">GitHub</a>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

            <div class="footer-copyright text-center">
                <p>{{ $t('site.footer_copyright_text') }}</p>
                <p>© 2013 - {{ currentYear }}
                    <a href="/humans.txt">{{ $t('site.footer_copyright_holder') }}</a></p>
            </div>
        </footer>
</template>
<script>
    export default {
        computed: {
            currentYear: function () {
                return (new Date()).getFullYear();
            }
        }
    }
</script>