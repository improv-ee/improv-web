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
                'https://api.dev.improv.ee',
                'https://api.test.improv.ee',
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
                'https://secure.gravatar.com'
            ])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::SCRIPT, Keyword::SELF)
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                'https://fonts.googleapis.com'
            ]);
    }
}