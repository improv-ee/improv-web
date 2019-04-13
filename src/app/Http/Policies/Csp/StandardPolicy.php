<?php

namespace App\Http\Policies\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;

class StandardPolicy extends Policy
{

    public function configure()
    {
        $this->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CONNECT, [
                Keyword::SELF,
                'https://api.local.improv.ee',
                'https://api.improv.ee',
                'https://sentry.io'
            ])
            ->addDirective(Directive::FRAME_ANCESTORS, Keyword::NONE)
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::FONT, [
                Keyword::SELF,
                'https://fonts.gstatic.com'
            ])
            ->addDirective(Directive::IMG, [
                Keyword::SELF,
                'data:',
                'http://improv.ee',
                'https://api.local.improv.ee',
                'https://api.improv.ee',
                'https://secure.gravatar.com',
                'https://www.google-analytics.com'
            ])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                'https://www.google-analytics.com',
                'https://sentry.io'
            ])
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                'https://fonts.googleapis.com'
            ])
        ->reportTo('https://sqroot.report-uri.com/r/d/csp/enforce');
    }
}