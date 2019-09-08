<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Unicodeveloper\Identify\Facades\IdentityFacade as Identify;

class SetApiLocale
{
    /**
     * This function checks if language to set is an allowed lang of config.
     *
     * @param string $locale
     **/
    private function setLocale($locale)
    {

        // Check if is allowed and set default locale if not
        if (!$locale || !language()->allowed($locale)) {
            $locale = config('app.locale');
        }

        // Set app language
        App::setLocale($locale);
    }


    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('language.auto')) {
            $this->setLocale(Identify::lang()->getLanguage());
        } else {
            $this->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
