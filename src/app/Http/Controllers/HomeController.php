<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return view('frontpage');
    }


    public function maintenance()
    {
        return view('errors.maintenance');
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @param \Illuminate\Http\Request $request
     *
     * @return RedirectResponse
     */
    public function locale($locale, Request $request): RedirectResponse
    {
        // Check if is allowed and set default locale if not
        if (!language()->allowed($locale)) {
            $locale = config('app.locale');
        }

        if (Auth::check()) {
            Auth::user()->setAttribute('locale', $locale)->save();
        } else {
            $request->session()->put('locale', $locale);
        }
        return redirect('/?lang=' . $locale);
    }
}
