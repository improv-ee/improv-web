<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;

class SetLocaleFromGeoIP
{

    /**
     * @return array Country code => language code to set
     */
    protected function getLanguageMap(): array
    {
        return [
            'ee' => 'et'
        ];
    }

    /**
     * @param string|null $country
     * @param Session $session
     */
    protected function setLanguageByCountry(?string $country, Session $session): void
    {
        if ($country === null) {
            return;
        }

        if (!array_key_exists($country, $this->getLanguageMap())) {
            return;
        }

        $session->put('locale', $this->getLanguageMap()[$country]);
    }

    /**
     * Set initial app language based on the visitors GeoIP
     *
     * This is not how it SHOULD be done (we should rely on browser preferred language instead),
     * but as many of the site's visitors are located in select number of countries; and many of
     * them have not bothered to set up their browser language preferences from default English,
     * they would get sub-optimal experience (default language=english).
     *
     * Hence, we'll default those select countries forcibly to a set language using their GeoIP.
     * This is only true when no language preference has been set, ie the user can still change
     * site language on demand, manually.
     *
     * We have CloudFlare in front of the site, so we'll get the user's country from an
     * internal HTTP header set by CloudFlare.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!$request->session()->has('locale')) {
            $requestCountry = mb_strtolower($request->header('CF-IPCountry'));
            $this->setLanguageByCountry($requestCountry, $request->session());
        }
        return $next($request);
    }
}
