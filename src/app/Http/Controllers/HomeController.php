<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vueConfig = [
            'apiUrl' => sprintf('https://%s/v1', env('API_DOMAIN'))
        ];

        return view('frontpage', ['vueConfig' => $vueConfig]);
    }


}
